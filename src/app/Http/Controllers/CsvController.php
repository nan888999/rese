<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ImportRequest;
use App\Models\Shop;
use Illuminate\Support\Facades\Validator;

class CsvController extends Controller
{
        public function viewImportCsv()
    {
        return view ('admin.import_csv');
    }

public function importCsv(ImportRequest $request)
{
    try {
        $file = $request->file('file');
        if (!$file) {
            throw new \Exception('ファイルがアップロードされていません');
        }
        $file_path = $file->storeAs('file', now()->format('YmdHisv') . '.csv');
        if (!$file_path) {
            throw new \Exception('ファイルパスが生成されていません');
        }
        $csv_data = $this->readCsvData($file_path);

        // CSVファイル内のバリデーションチェック
        $validate_errors = $this->validateCsvData($csv_data);

        // バリデーションエラーがあれば
        if (!empty($validate_errors)) {  // 空でない場合
            return redirect()->back()->withErrors(['upload_errors' => $validate_errors]);
        }

        // バリデーションエラーがない場合、処理を続ける
        // ここでデータ処理を行う
        $this->insertCsvData($csv_data);

        // 正常終了
        return redirect()->back()->with('message', 'CSVファイルをインポートしました');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
    }
}


    /**
     * CSVファイルからデータを読み込み、配列として返す
     */
    private function readCsvData($filePath)
    {
        $csv_data = [];
        if (($handle = fopen(storage_path('app/' . $filePath), 'r')) !== false) {
            $header = fgetcsv($handle); // ヘッダーをスキップ
            while (($data = fgetcsv($handle)) !== false) {
                // Shift-JISからUTF-8に変換
                $data = array_map(function ($item) {
                    return mb_convert_encoding($item, 'UTF-8', 'SJIS-win');
                }, $data);

                $csv_data[] = [
                    'name' => $data[0],
                    'area_id' => $data[1],
                    'category_id' => $data[2],
                    'detail' => $data[3],
                    'img_url' => $data[4],
                ];
            }
            fclose($handle);
        }
        return $csv_data;
    }

private function validateCsvData(array $csv_data)
    {
        $area_mapping = [
            '東京都' => 1,
            '大阪府' => 2,
            '福岡県' => 3,
        ];

        $category_mapping = [
            'イタリアン' => 1,
            'ラーメン' => 2,
            '居酒屋' => 3,
            '寿司' => 4,
            '焼肉' => 5,
        ];

        $rules = [
            'name' => [
                'required', 'string', 'max:50', 'regex:/^[^#<>^;_]*$/'
            ],
            'area_id' => [
                'required', 'integer', 'in:1,2,3',
            ],
            'category_id' => [
                'required', 'integer', 'in:1,2,3,4,5',
            ],
            'detail' => [
                'required', 'string', 'max:200',
            ],
            'img_url' => [
                'required', 'string', 'max:255', 'active_url', 'regex:/\.(png|jpeg)$/i',
            ],
        ];

        // バリデーション対象項目名
        $attributes = [
            'name' => '店舗名',
            'area_id' => '地域ID',
            'category_id' => 'ジャンルID',
            'detail'   => '店舗概要',
            'img_url'   => '画像URL',
        ];

        $messages = [
            'area_id.in' => ':attributeには1〜3の整数を指定してください。',
            'category_id.in' => ':attributeには1〜5の整数を指定してください。',
            'img_url.regex' => ':attributeはPNGまたはJPEG形式の画像URLを指定してください。',
        ];

        // エラーメッセージ格納用配列
        $upload_error_list = [];

        // 各行に対してバリデーションを実施
        foreach ($csv_data as $key => $value) {
            $validator = Validator::make($value, $rules, $messages, $attributes);

            // バリデーションエラーがあれば
            if ($validator->fails()) {
                $error_messages = array_map(function ($message) use ($key) {
                    return ($key + 2) . "行目：" . $message;
                }, $validator->errors()->all());
                $upload_error_list = array_merge($upload_error_list, $error_messages);
            }
        }
        return $upload_error_list;
    }

    private function insertCsvData($csv_data)
    {

        foreach ($csv_data as $key => $data) {
            $shop = new Shop();
            $shop->name = $data['name'];
            $shop->area_id = $data['area_id'];
            $shop->category_id = $data['category_id'];
            $shop->detail = $data['detail'];
            $shop->img_url = $data['img_url'];

            $shop->save();
        }
    }

}
