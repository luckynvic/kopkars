<?php

use yii2mod\rbac\migrations\Migration;

class m220519_020401_init extends Migration
{
    public function safeUp()
    {
        $user = new \common\models\User;
        $user->kode_toko = 'hiiphooray';
        $user->email = 'admin@email.com';
        $user->password_default = '12345678';
        $user->setPassword($user->password_default);
        $user->generateAuthKey();
        $user->save(false);

        $sys_admin = $this->createRole('sys-admin', 'System Adminitration');
        $admin = $this->createRole('admin', 'Operation Administration');
        $user = $this->createRole('user', 'Default User');

        $item = $this->createPermission('All Pengaturan Sistem', 'Pengaturan Sistem');
        $this->addChild($sys_admin, $item);
        $item = $this->createPermission('All Sistem Marketplace', 'All Sistem Marketplace');
        $this->addChild($sys_admin, $item);
        $item = $this->createPermission('All Master Marketplace', 'All Master Marketplace');
        $this->addChild($sys_admin, $item);
        $item = $this->createPermission('All Setting Marketplace', 'All Setting Marketplace');
        $this->addChild($sys_admin, $item);
        $item = $this->createPermission('All Export Marketplace', 'All Export Marketplace');
        $this->addChild($admin, $item);
        $item = $this->createPermission('All Manajemen Anggota', 'All Manajemen Anggota');
        $this->addChild($admin, $item);
        $item = $this->createPermission('All Anggota Simpanan', 'All Anggota Simpanan');
        $this->addChild($admin, $item);
        $item = $this->createPermission('All Pinjaman', 'All Pinjaman');
        $this->addChild($admin, $item);
        $item = $this->createPermission('All Cicilan', 'All Cicilan');
        $this->addChild($admin, $item);
        $item = $this->createPermission('All Transaksi', 'All Transaksi');
        $this->addChild($admin, $item);
        $item = $this->createPermission('All Voucher', 'All Voucher');
        $this->addChild($admin, $item);

        $this->assign($sys_admin, $user->id);
    }

    public function safeDown()
    {
        \common\models\User::deleteAll(['email'=>'admin@email.com']);

        $this->removeRole('sys-admin');
        $this->removeRole('admin');
        $this->removeRole('user');

        $this->removePermission('All Pengaturan Sistem');
        $this->removePermission('All Sistem Marketplace');
        $this->removePermission('All Master Marketplace');
        $this->removePermission('All Setting Marketplace');
        $this->removePermission('All Export Marketplace');
        $this->removePermission('All Manajemen Anggota');
        $this->removePermission('All Anggota Simpanan');
        $this->removePermission('All Pinjaman');
        $this->removePermission('All Cicilan');
        $this->removePermission('All Transaksi');
        $this->removePermission('All Voucher');
    }
}