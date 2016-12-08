<?php

namespace App\DataTables;

use App\Player;
use Yajra\Datatables\Services\DataTable;

class PlayersDataTable extends DataTable
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return $this->datatables
            ->eloquent($this->query())
            ->addColumn('action', 'path.to.action.view')
            ->make(true);
    }

    /**
     * Get the query object to be processed by dataTables.
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|\Illuminate\Support\Collection
     */
    public function query()
    {
        $query = Player::query();

        return $this->applyScopes($query);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\Datatables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->ajax('')
            ->addAction(['width' => '80px'])
            ->parameters($this->getBuilderParameters())
            //FIXME: 語系等預設參數應提出
            ->parameters([
                'order'      => [[0, 'asc']],
                'pageLength' => 50,
                'oLanguage'  => [
                    'sProcessing'   => '處理中...',
                    'sLengthMenu'   => '顯示 _MENU_ 項結果',
                    'sZeroRecords'  => '沒有匹配結果',
                    'sInfo'         => '顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項',
                    'sInfoEmpty'    => '顯示第 0 至 0 項結果，共 0 項',
                    'sInfoFiltered' => '（從 _MAX_ 項結果過濾）',
                    'sSearch'       => '搜索：',
                    'oPaginate'     => [
                        'sFirst'    => '第一頁',
                        'sPrevious' => '上一頁',
                        'sNext'     => '下一頁',
                        'sLast'     => '最後一頁',
                    ],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['data' => 'id', 'title' => '#'],
            ['data' => 'nid', 'title' => 'NID'],
            ['data' => 'app_uid', 'title' => 'App UID'],
            ['data' => 'uid', 'title' => 'UID'],
            ['data' => 'in_question', 'title' => 'In Question'],
            ['data' => 'time', 'title' => 'Times'],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'players_' . time();
    }
}
