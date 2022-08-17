<?php

namespace App\Models;

use App\Traits\ModelTableNameTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

/**
 * App\Models\OrderReport
 *
 * @property int $id
 * @property int $order_id
 * @property string $path
 * @property int $status
 * @property string $created_at
 * @property int $type
 * @property-read mixed $name
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReport query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReport whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReport wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReport whereType($value)
 * @mixin \Eloquent
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReport whereUpdatedAt($value)
 */
class OrderReport extends Model
{
    use HasFactory;

    const PATH = 'reports/';

    const PATH_1C_PROCESSOR = '/home/dev/index';

    const STATUS_GENERATED = 1;
    const STATUS_GENERATION_FAILED = 2;
    const STATUS_SENT_TO_1C = 3;
    const STATUS_FAILED_SENDING_TO_1C = 4;
    const STATUS_MOVED_TO_LOCAL_1C_PROCESSOR = 5;
    const STATUS_FAILED_MOVING_TO_LOCAL_1C_PROCESSOR = 6;

    const REPORT_TYPE_ORDER = 0;
    const REPORT_TYPE_RETURN = 1;
    const REPORT_TYPE_WAYBILL = 2;


    const REPORTS_TYPES = [
        self::REPORT_TYPE_ORDER => "ORDER",
        self::REPORT_TYPE_RETURN => "RETURN",
        self::REPORT_TYPE_WAYBILL => "WAYBILL",
    ];

    const DOCUMENT_NAMES_1C = [
        self::REPORT_TYPE_ORDER => 220,
        self::REPORT_TYPE_RETURN => 320,
        self::REPORT_TYPE_WAYBILL => 420,
    ];


    protected $guarded = [
        'id'
    ];

    public $timestamps = false;

    public $orderType = '';

    public $sendingStatus = '';

    public $moveStatus = '';

    public static function generate(Order $order, string $dates, $rootPath = self::PATH_1C_PROCESSOR)
    {
        $type = 0;
        $counteragent_id_1c = $order->salesrep->counterparty->id_1c;


        $dateObj = Carbon::parse($order->created_at)->addDay();//->format('Y-m-d');
        $weekDay = date('w', strtotime(Carbon::parse($order->created_at)->format('Y-m-d')));
        if ($order->salesrep_id == 20 or $order->salesrep_id == 88) {
            switch ($weekDay) {
                case 1:
                    $dateObj = Carbon::parse($order->created_at)->addDay();//->addDay()->format('Y-m-d');
                    break;
                case 3:
                    $dateObj = Carbon::parse($order->created_at)->addDay();//->addDay()->format('Y-m-d');
                    break;
                default:
                    $dateObj = Carbon::parse($order->created_at)->addDay();//->format('Y-m-d');
                    break;
            }
        }
        $date = $dateObj->format('Y-m-d');
        $name = self::generateReportName($order, $type, $dateObj);
        $path = self::PATH . "$dates/$name";
        try {
            $output = View::make('onec.report_template')->with(compact('order', 'type', 'counteragent_id_1c', 'date'))->render();
            $output = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n" . $output;

            //storing in local storage
            Storage::disk('public')->put($path, $output);

            //storing in 1c processor folder
            $client = Storage::createLocalDriver(['root' => $rootPath]);
            $client->put($name, $output);

        } catch (Exception $e) {

            self::query()->create([
                'order_id' => $order->id,
                'path' => $path,
                'status' => self::STATUS_GENERATION_FAILED,
                'created_at' => $date,
                'type' => $type
            ]);

            throw new Exception($e->getMessage());
        }

        if ($type != 2) {
            self::query()->create([
                'order_id' => $order->id,
                'path' => $path,
                'status' => self::STATUS_GENERATED,
                'created_at' => $date,
                'type' => $type
            ]);

        }
        return $path;
    }

    public static function generateReturn(Order $order, string $dates, $rootPath = self::PATH_1C_PROCESSOR)
    {
        $type = 1;
        $counteragent_id_1c = $order->salesrep->counterparty->id_1c;

        $dateObj = Carbon::parse($order->created_at)->addDay();//->format('Y-m-d');
        $weekDay = date('w', strtotime(Carbon::parse($order->created_at)->format('Y-m-d')));
        if ($order->salesrep_id == 20 or $order->salesrep_id == 88) {
            switch ($weekDay) {
                case 1:
                    $dateObj = Carbon::parse($order->created_at)->addDay();//->addDay()->format('Y-m-d');
                    break;
                case 3:
                    $dateObj = Carbon::parse($order->created_at)->addDay();//->addDay()->format('Y-m-d');
                    break;
                default:
                    $dateObj = Carbon::parse($order->created_at)->addDay();//->format('Y-m-d');
                    break;
            }
        }
        $date = $dateObj->format('Y-m-d');
        $name = self::generateReportName($order, $type, $dateObj);
        $path = self::PATH . "$dates/$name";
        try {
            $output = View::make('onec.report_return_template')->with(compact('order', 'type', 'counteragent_id_1c', 'date'))->render();
            $output = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n" . $output;

            //storing in local storage
            Storage::disk('public')->put($path, $output);

            //storing in 1c processor folder
            $client = Storage::createLocalDriver(['root' => $rootPath]);
            $client->put($name, $output);

        } catch (Exception $e) {

            self::query()->create([
                'order_id' => $order->id,
                'path' => $path,
                'status' => self::STATUS_GENERATION_FAILED,
                'created_at' => $date,
                'type' => $type
            ]);

            throw new Exception($e->getMessage());
        }

        if ($type != 2) {
            self::query()->create([
                'order_id' => $order->id,
                'path' => $path,
                'status' => self::STATUS_GENERATED,
                'created_at' => $date,
                'type' => $type
            ]);

        }
        return $path;
    }

    public function sendTo1C($report)
    {
        $file = Storage::disk('public')->get($report->path);
        $success = Storage::disk('ftp-1c')->put("index/" . basename($report->path), $file);

        if ($success) {
            $this->sendingStatus = 'success';
        } else {
            $this->sendingStatus = 'failed';
        }
    }

    public function getNameAttribute()
    {
        $arr = explode('/', $this->path);

        return $arr[3];
    }

    public static function generateReportName($order, int $type, $dateObj)
    {
        $head = self::REPORTS_TYPES[$type];
        $todayDateFor1C = now()->format('YmdHis');
        if ($type == 1) {
            $todayDateFor1C = $dateObj->format('YmdHis');
        }
        return $head . "_$todayDateFor1C" . "_{$order->salesrep->counterparty->id_1c}_9864232489962_{$order->id}" . ".xml";
    }

    public function determineOrder($order)
    {
        $totalCount = 0;
        $returnsCount = 0;

        foreach ($order->basket as $product) {
            if ($product['type'] == Order::BASKET_PRODUCT_TYPE_FOR_RETURN) {
                $returnsCount++;
            }
            $totalCount++;
        }

        if ($returnsCount === $totalCount) {
            $this->orderType = 'return';
        } else {
            $this->orderType = 'order';
        }
    }
}
