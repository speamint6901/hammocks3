<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseAdminController;

class TopController extends BaseAdminController
{
    // 管理者登録トップ
    public function showIndex() {
        return \View::make('admin.top', $this->data);
    }
}
