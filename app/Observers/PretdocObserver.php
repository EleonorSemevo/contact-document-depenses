<?php
namespace App\Observers;

use App\Models\Pretdoc;


class PretdocObserver
{
    public function updated(Pretdoc $pretdoc)
    {
       // $pretdoc['date_reelle'] = null;
    }

    public function created(Pretdoc $pretdoc)
    {
        //$pretdoc['date_reelle'] = null;
    }
}
