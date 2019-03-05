<?php
use yii\helpers\Url; 
?>
<div style="padding: 20px 30px; background: #e45543; z-index: 999999; font-size: 16px; font-weight: 600;">
    <p style="color: rgba(255, 255, 255, 0.9); display: inline-block; margin-right: 10px; text-decoration: none;">Terdapat data demosi pegawai yang tanggal efektifnya sudah jatuh tempo. Klik tombol "Lihat Data".</p>
    <a class="btn btn-default btn-sm" href="<?= Url::to(['/remuneration/demotion/do-complete'], true) ?>" style="margin-top: -5px; border: 0px; box-shadow: none; color: #e45543; font-weight: 600; background: rgb(255, 255, 255);">Lihat Data</a>
</div>