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
            ->addColumn('action', function ($player) {
                $html = '';
                $html .= '<a href="' . route('player.showByUuid', $player->uuid) . '" ';
                $html .= 'class="btn btn-primary" title="玩家資訊" target="_blank">';
                $html .= '<i class="fa fa-user" aria-hidden="true"></i>';
                $html .= '</a>';
                if ($player->nid) {
                    $html .= '<form action="' . route('player.unbind', $player) . '" method="POST"';
                    $html .= ' onsubmit="return confirm(\'確定解除NID綁定？\')" style="display: inline">';
                    $html .= '<input type="hidden" name="_token" id="csrf-token" value="' . csrf_token() . '" />';
                    $html .= '<button type="submit" class="btn btn-danger" title="解除NID綁定">';
                    $html .= '<i class="fa fa-chain-broken" aria-hidden="true"></i>';
                    $html .= '</button>';
                    $html .= '</form>';
                }

                return $html;
            })
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
            ->addAction()
            ->ajax('')
            ->parameters($this->getBuilderParameters())
            ->parameters([
                'order'      => [[0, 'asc']],
                'pageLength' => 50,
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
            [
                'data'  => 'id',
                'name'  => 'id',
                'title' => '#',
            ],
            [
                'data'  => 'nid',
                'name'  => 'nid',
                'title' => 'NID',
            ],

            [
                'data'  => 'app_uid',
                'name'  => 'app_uid',
                'title' => 'App UID',
            ],

            [
                'data'  => 'in_question',
                'name'  => 'in_question',
                'title' => '正在解題',
            ],

            [
                'data'  => 'time',
                'name'  => 'time',
                'title' => '完成次數',
            ],

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
