<?php

namespace App\Console\Commands;

use App\Notifications\Notify;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SalesReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and send Sales Report for the day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sales = DB::select("SELECT orders.created_at AS date,
            vendors.id AS vendor_id, vendors.name AS vendor_name,
COUNT(DISTINCT orders.id) AS total_orders,
SUM(orders.sub_total) AS total_sales
FROM orders
JOIN vendors ON orders.vendor_id = vendors.id
WHERE orders.status = 5
GROUP BY DATE(orders.created_at), orders.vendor_id
ORDER BY DATE(orders.created_at) DESC");
//dd($sales);

        foreach ($sales as $sale)
        {
//            dd($sale->vendor_id);
            $sale->details = DB::select("
            SELECT
order_lines.item_name,
order_lines.item_id,
order_lines.created_at,
SUM(order_lines.quantity) AS items_sold,
(order_lines.quantity) * order_lines.item_price AS sales
FROM order_lines
JOIN orders ON orders.id = order_lines.order_id
AND orders.vendor_id = $sale->vendor_id
WHERE DATE(order_lines.created_at) = DATE('$sale->date')
AND orders.status = 5
GROUP BY order_lines.item_id");

            Notify::sendSalesReport($sale);

        }

    }
}
