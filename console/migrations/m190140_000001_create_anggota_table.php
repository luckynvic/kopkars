<?php

use yii\db\Migration;

class m190140_000001_create_anggota_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('anggota', [
            'id' => $this->primaryKey(),
            'status' => $this->string(20),
            'status_karyawan' => $this->string(20),
            'nomor_anggota' => $this->string(20)->unique(),
            'nomor_pegawai' => $this->string(20)->unique(),
            'email' => $this->string(50)->unique(),
            'email_last_lock' => $this->string(50)->unique(),
            'email_last_lock_verified' => $this->boolean()->defaultValue(false),
            'password_default' => $this->string(150),
            'foto' => $this->binary(),
            'foto_thumbnail' => $this->binary(),
            'unit' => $this->string(100),
            'nomor_hp' => $this->string(50)->unique(),
            'nomor_hp_last_lock' => $this->string(20)->unique(),
            'nomor_hp_last_lock_verified' => $this->boolean()->defaultValue(false),
            'nomor_ktp' => $this->string(16),
            'nama_lengkap' => $this->string(50),
            'tempat_lahir' => $this->string(50),
            'tanggal_lahir' => $this->date(),
            'jenis_kelamin' => $this->string(1),
            'agama' => $this->string(20),
            'pendidikanterakhir' => $this->string(20),
            'alamat_rumah' => $this->string(),
            'nomor_npwp' => $this->string(15),
            'keterangan' => $this->string(),
            'waktu_daftar' => $this->dateTime()->notNull()->defaultExpression('now()'),
            'waktu_update' => $this->dateTime(),
            'waktu_login' => $this->dateTime(),
            'waktu_approve' => $this->dateTime(),
            'approved_by' => $this->string(150),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string(255),
            'password_reset_token' => $this->string(255),
            'verification_token' => $this->string(255),
            'nomor_zahir' => $this->string(20)->unique(), //hanya sementara selama proses migrasi data, nanti di zahir semua akan diganti jadi nomor_anggota
        ]);

        $this->addForeignKey('anggota_variabel_status_fkey', 'anggota', 'status', 'variabel_status', 'status', 'RESTRICT', 'CASCADE');

        $this->addForeignKey('anggota_variabel_statuskaryawan_fkey', 'anggota', 'status_karyawan', 'variabel_statuskaryawan', 'statuskaryawan', 'RESTRICT', 'CASCADE');
        
        $this->addForeignKey('anggota_variabel_unit_fkey', 'anggota', 'unit', 'variabel_unit', 'unit', 'RESTRICT', 'CASCADE');

        $this->addForeignKey('anggota_variabel_agama_fkey', 'anggota', 'agama', 'variabel_agama', 'agama', 'RESTRICT', 'CASCADE');

        $this->addForeignKey('anggota_variabel_pendidikanterakhir_fkey', 'anggota', 'pendidikanterakhir', 'variabel_pendidikanterakhir', 'pendidikanterakhir', 'RESTRICT', 'CASCADE');
        
        $this->createIndex('anggota_nomor_anggota_idx', 'anggota', 'nomor_anggota');
       
        $this->createIndex('anggota_nama_lengkap_idx', 'anggota', 'nama_lengkap');

        $sql = file_get_contents(Yii::getAlias('@kopkars-assets/sql/trigger_anggota_insertupdate.sql'));
        $this->execute($sql);
        
        $this->execute('
        CREATE TRIGGER trigger_anggota_insertupdate AFTER INSERT OR UPDATE ON anggota
        FOR EACH ROW
        EXECUTE PROCEDURE trigger_anggota_insertupdate()
        ');
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('anggota');
    }
}
