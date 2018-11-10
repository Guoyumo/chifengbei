<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use App\Http\Controllers\WechatService;

class ImportQrcode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qrcodes:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import qrcode';

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
    public function handle(WechatService $wechat)
    {
        //
        // $qrcode = DB::table('q_rcodes')->where('id',2)->first();
        // $qrcode = DB::table('q_rcodes')->insert(
        //     ['id' => 49, 'name' => 'test','type'=>'content','media_id'=>'content']
        // );
        // $wechat->generatePermanentQRcode(49);
        $path = public_path();
        $row = 1;
        $file = fopen($path."/qrcode.csv", "r");
        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
            $num = count($data);
            $row++;
            if(isset($data[1])){
                $this->info($data[1]);
                $qrcode = DB::table('q_rcodes')->insert(
                    ['id' => $data[1], 'name' => $data[0],'type'=>'content','media_id'=>'欧缇丽臻美亮白精华液了解一下！成分安全，淡化斑点痘印、亮白肤色，孕妇也可以安心使用！超值套装火热销售中']
                );
                $wechat->generatePermanentQRcode($data[1]);
            }else{
                $explode = explode(',',$data[0]);
                $this->comment($explode[1]);
                $qrcode = DB::table('q_rcodes')->insert(
                    ['id' => $explode[1], 'name' => $explode[0],'type'=>'content','media_id'=>'欧缇丽臻美亮白精华液了解一下！成分安全，淡化斑点痘印、亮白肤色，孕妇也可以安心使用！超值套装火热销售中']
                );
                $wechat->generatePermanentQRcode($explode[1]);
            }  
            

        }
        fclose($file);
    }
}
