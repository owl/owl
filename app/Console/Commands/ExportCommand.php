<?php namespace Owl\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Owl\Services\ItemService;

class ExportCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export application data.';

    protected $itemService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $this->info("エクスポートを開始します... \n");

        // 空フォルダを作成
        $export_path = storage_path() . '/export/';
        $this->makeExportDir($export_path);

        // 記事ID一覧の取得
        $items = $this->itemService->getAll();
        if (empty($items)) {
            $this->info("エクスポート対象の記事が見つかりませんでした。\n"
                . "エクスポートをを終了します。\n");
            return;
        }

        // 100件区切りでデータエクスポート
        $chunk = 100;
        for ($i = 0; $i <= count($items); $i += $chunk) {
            $target_items = array_slice($items, $i, 100);
            $this->exportData($export_path, $target_items);
            echo count($target_items) + $i . '/' . count($items) . "\n";
            usleep(500000);
        }

        $this->info("\n\nファイルが storage/export にあるか確認してください。 \n");
        $this->info("\n\nエクスポートを終了しました。\n");
    }

    protected function makeExportDir($export_path)
    {
        if (!is_dir($export_path)) {
            mkdir($export_path, 0777);
        }
    }

    protected function exportData($export_path, $items)
    {
        foreach ($items as $item) {
            $data = [];
            $data['id']           = $item->id;
            $data['title']        = $item->title;
            $data['username']     = $item->username;
            $data['body']         = $item->body;
            $data['published']    = ($item->published === "0") ? "false" : "true";
            $data['created_at']   = $item->created_at;
            $data['updated_at']   = $item->updated_at;

            $item_tags = $this->itemService->getTagsToArray($item);
            $tags = '';
            foreach ($item_tags as $item_tag) {
                $tags .= "{$item_tag['name']} ";
            }
            $data['tags'] = str_replace(' ', ', ', trim($tags));

            $output = $this->generateOutputBody($data);

            $filename = date("Y-m-d", strtotime($data['updated_at']))
                . '-' . $data['title'] . '-(id' . $data['id'] . ').html.md';
            file_put_contents($export_path . $filename, $output);
            echo ".";
        }
    }

    protected function generateOutputBody($data)
    {
        $template = <<<EOM
---
title: "{$data['title']}"
date: {$data['updated_at']}
tags: {$data['tags']}
author: "{$data['username']}"
published: {$data['published']}
created_at: {$data['created_at']}
updated_at: {$data['updated_at']}
---

{$data['body']}
EOM;
        return $template;
    }
}
