<?php

use yii\db\Migration;

/**
 * Class m220518_115520_pegawai
 */
class m220518_115520_pegawai extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('pegawai', [
            'id' => $this->bigPrimaryKey(),
            'nomor_pegawai' => $this->integer(),
            'pegKodeResmi' => $this->string()->notNull(),
            'pegNama' => $this->string()->notNull(),
            'pegAlamat' => $this->string(),
            'pegNoHp' => $this->string(),
            'pegEmail' => $this->string(),
            'pegIdLain' => $this->string(),
            'pegTmpLahir' => $this->string(),
            'pegTglLahir' => $this->date(),
            'pegKelamin' => $this->integer(),
            'pegAgamaId' => $this->integer(),
            'pegDesaRumah' => $this->string(),
            'pegKecRumah' => $this->string(),
            'pegNoNPWP' => $this->string(),
            'pegKotaRumah' => $this->string(),
            'pegProvinsiRumah' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('pegawai');
    }
}
