<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use common\models\DbpegawaiPubPegawai;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;


/**
 * This is the model class for table "anggota".
 *
 * @property int $id
 * @property string $kode_toko
 * @property string|null $status
 * @property string|null $status_karyawan
 * @property string|null $nomor_anggota
 * @property string|null $nomor_pegawai
 * @property string|null $nomor_zahir 
 * @property string|null $email
 * @property string|null $email_last_lock
 * @property bool|null $email_last_lock_verified
 * @property string|null $password_default
 * @property resource|null $foto
 * @property resource|null $foto_thumbnail
 * @property resource|null $foto_ktp
 * @property resource|null $foto_ktp_thumbnail
 * @property string|null $unit
 * @property string|null $nomor_hp
 * @property string|null $nomor_hp_last_lock
 * @property bool|null $nomor_hp_last_lock_verified
 * @property string|null $nomor_ktp
 * @property string|null $nama_lengkap
 * @property string|null $tempat_lahir
 * @property string|null $tanggal_lahir
 * @property string|null $jenis_kelamin
 * @property string|null $agama
 * @property string|null $pendidikanterakhir
 * @property string|null $alamat_rumah
 * @property string|null $nomor_npwp
 * @property string|null $keterangan
 * @property string $waktu_daftar
 * @property string|null $waktu_update
 * @property string|null $waktu_login
 * @property string|null $waktu_approve
 * @property string|null $approved_by
 * @property string|null $auth_key
 * @property string|null $password_hash
 * @property string|null $password_reset_token
 * @property string|null $verification_token
 * @property string|null $access_token
 * @property integer|null expire_at
 *
 * @property VariabelAgama $agama
 * @property VariabelPendidikanterakhir $pendidikanTerakhir
 * @property VariabelStatus $status
 * @property VariabelStatuskaryawan $statuskaryawan
 * @property VariabelUnit $unit
 * @property HistoriAnggotaStatus[] $historiAnggotaStatuses
 */
class Anggota extends \yii\db\ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 'Aktif';
    const STATUS_NULL = NULL;
    const EMAIL_VERIFIED = TRUE;
    const EMAIL_NOT_VERIFIED = FALSE;

    public $username;
	public $re_password;
	public $captcha;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anggota';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['waktu_daftar'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['waktu_update'],
                ],
                 'value' => 'now()'
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->generateAuthKey();
                $this->setPassword($this->password_default);
            }
            return true;
        }
        return false;
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->nama_lengkap = strtoupper($this->nama_lengkap);
            $this->tempat_lahir = strtoupper($this->tempat_lahir);
            if(!empty($this->email)) {
                $this->email = strtolower($this->email);
            }
            $this->alamat_rumah = strtoupper($this->alamat_rumah);
            return true;
        }
        return false;
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'email_last_lock_verified' => self::EMAIL_VERIFIED]);
    }

    public function generateAccessToken()
    {
        $this->access_token=Yii::$app->security->generateRandomString();
        return $this->access_token;
    }
    
    // public static function findIdentityByAccessToken($token, $type = null)
    // {
    //     throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    // }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = static::find()->where(['access_token' => $token, 'status' => self::STATUS_ACTIVE])->one();
        if (!$user) {
            return false;
        }
        if ($user->expire_at < time()) {
            throw new UnauthorizedHttpException('the access - token expired ', -1);
        } else {
            return $user;
        }
    }
    
    public static function findByEmail($email)
    {
        return static::findOne(['email_last_lock' => $email, 'email_last_lock_verified' => self::EMAIL_VERIFIED]);
    }

    //BELUM BERES INI UNTUK HAK AKSES, BISA DI KEBELAKANGIN
    public static function findByEmailAssignment($email)
    {
        return static::find(['email_last_lock' => $email, 'status' => self::STATUS_ACTIVE])->innerJoin('auth_assignment', 'anggota.id = auth_assignment.user_id::integer')->one();
    }
    
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        
        return static::findOne([
            'password_reset_token' => $token,
            'email_last_lock_verified' => self::EMAIL_VERIFIED,
        ]);
    }

    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'email_last_lock_verified' => FALSE
        ]);
    }
    
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        
        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
    
    public function getId()
    {
        return $this->getPrimaryKey();
    }
    
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['nomor_hp', 'match' ,'pattern'=>'/^(8)[1-9][0-9]{7,10}/','message'=> 'Masukan nomor HP tanpa 0 atau 62 atau +62'],
            ['kode_toko', 'match' ,'pattern'=>'/^[A-Za-z0-9._-]+$/u','message'=> 'Only alphanumeric, dot(.), underscore(_), and hypen(-)'],
            [['nomor_ktp', 'nomor_npwp', 'nomor_hp'], 'match' ,'pattern'=>'/^[0-9]+$/u','message'=> 'Hanya boleh angka'],
            [['foto','foto_ktp'], 'file', 'extensions' => 'png,jpg,jpeg', 'mimeTypes'=>'image/jpeg,image/png','maxSize'=>2097152],
            [['email_last_lock_verified', 'nomor_hp_last_lock_verified'], 'boolean'],
            [['tanggal_lahir', 'waktu_daftar', 'waktu_update', 'waktu_login', 'waktu_approve'], 'safe'],
            [['status', 'status_karyawan', 'nomor_anggota', 'nomor_pegawai', 'agama', 'pendidikanterakhir'], 'string', 'max' => 20],
            [['kode_toko','nomor_hp', 'nama_lengkap', 'tempat_lahir', 'email', 'approved_by'], 'string', 'max' => 50],
            [['password_default','re_password'], 'string', 'min' => 8],
            [['password_default','re_password'], 'string', 'max' => 150],
            [['kode_toko', 'foto', 'foto_ktp', 'email', 'nomor_hp', 'nomor_pegawai', 'unit', 'status_karyawan', 'nomor_ktp', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'pendidikanterakhir', 'alamat_rumah','nomor_npwp'], 'required'],
            [['email','email_last_lock_verified'], 'email'],
            [['password_default','re_password','captcha'], 'required','on' => 'frontend-create-anggota'],
            ['re_password', 'compare', 'compareAttribute'=>'password_default', 'skipOnEmpty' => false, 'message'=>'Re-Password aplikasi tidak sama'],
            [['unit'], 'string', 'max' => 100],
            [['nomor_ktp'], 'string', 'length' => 16],
            [['nomor_npwp'], 'string', 'length' => 15],
            [['jenis_kelamin'], 'string', 'max' => 1],
            [['nomor_hp'], 'string', 'min' => 9],
            [['nomor_hp'], 'string', 'max' => 12],
            [['alamat_rumah', 'keterangan', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'unique', 'targetAttribute' => ['kode_toko', 'email'], 'message'=>'Email telah dipakai orang lain, mohon gunakan data lain.'],
            [['email_last_lock'], 'unique', 'targetAttribute' => ['kode_toko', 'email_last_lock'], 'message'=>'Email last lock telah dipakai orang lain, mohon gunakan data lain.'],
            [['nomor_anggota'], 'unique', 'targetAttribute' => ['kode_toko', 'nomor_anggota'], 'message'=>'No. anggota telah dipakai orang lain, mohon gunakan data lain.'],
            [['nomor_pegawai'], 'unique', 'targetAttribute' => ['kode_toko', 'nomor_pegawai'], 'message'=>'No. pegawai telah dipakai orang lain, mohon gunakan data lain.'],
            [['nomor_hp'], 'unique', 'targetAttribute' => ['kode_toko', 'nomor_hp'], 'message'=>'No. HP telah dipakai orang lain, mohon gunakan data lain.'],
            [['nomor_hp_last_lock'], 'unique', 'targetAttribute' => ['kode_toko', 'nomor_hp_last_lock'], 'message'=>'No. HP telah dipakai orang lain, mohon gunakan data lain.'],
            [['nomor_zahir'], 'unique', 'targetAttribute' => ['kode_toko', 'nomor_zahir'], 'message'=>'No. Zahir telah dipakai orang lain, mohon gunakan data lain.'],
            [['kode_toko'], 'exist', 'skipOnError' => true, 'targetClass' => Toko::className(), 'targetAttribute' => ['kode_toko' => 'kode']],
            [['agama'], 'exist', 'skipOnError' => true, 'targetClass' => VariabelAgama::className(), 'targetAttribute' => ['agama' => 'agama']],
            [['pendidikanterakhir'], 'exist', 'skipOnError' => true, 'targetClass' => VariabelPendidikanterakhir::className(), 'targetAttribute' => ['pendidikanterakhir' => 'pendidikanterakhir']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => VariabelStatus::className(), 'targetAttribute' => ['status' => 'status']],
            [['status_karyawan'], 'exist', 'skipOnError' => true, 'targetClass' => VariabelStatuskaryawan::className(), 'targetAttribute' => ['status_karyawan' => 'statuskaryawan']],
            [['unit'], 'exist', 'skipOnError' => true, 'targetClass' => VariabelUnit::className(), 'targetAttribute' => ['unit' => 'unit']],
            ['captcha', 'captcha']
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['default'] = [];
        $scenarios['api-set-token'] = ['access_token','expire_at'];
        $scenarios['backend-nomor_anggota-anggota'] = ['status', 'waktu_approve','approved_by'];
        $scenarios['backend-updateemail-anggota'] = ['email'];
        $scenarios['backend-updatehp-anggota'] = ['nomor_hp'];
        $scenarios['backend-updatestatus-anggota'] = ['status'];
        $scenarios['frontend-create-anggota'] = ['kode_toko','foto','foto_ktp','email','password_default','re_password','nomor_hp', 'nomor_hp_last_lock', 'nomor_hp_last_lock_verified', 'nomor_pegawai'];
        $scenarios['frontend-update-anggota'] = ['nomor_pegawai', 'status_karyawan', 'unit', 'nomor_ktp', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'pendidikanterakhir', 'alamat_rumah','nomor_npwp'];
        $scenarios['frontend-update-anggota-email'] = ['email', 'captcha'];
        $scenarios['frontend-update-anggota-foto'] = ['foto'];
        $scenarios['frontend-update-anggota-foto_ktp'] = ['foto_ktp'];
        $scenarios['frontend-update-anggota-hp'] = ['nomor_hp', 'captcha'];
        $scenarios['updateallpassword'] = ['auth_key','password_hash','password_reset_token'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_toko' => 'Kode Toko',
            'status' => 'Status Koperasi',
            'status_karyawan' => 'Status',
            'nomor_anggota' => 'Nomor Koperasi',
            'nomor_pegawai' => 'Nomor Pegawai',
            'nomor_zahir' => 'Nomor Zahir',
            'email' => 'Email',
            'password_default' => 'Password',
            're_password' => 'Ulangi Password',
            'foto' => 'Foto',
            'foto_thumbnail' => 'Foto Thumbnail',
            'foto_ktp' => 'Foto/Scan KTP',
            'foto_ktp_thumbnail' => 'Foto/Scan KTP Thumbnail',
            'unit' => 'Unit',
            'nomor_hp' => 'Nomor HP',
            'nomor_ktp' => 'Nomor KTP',
            'nama_lengkap' => 'Nama Lengkap',
            'tempat_lahir' => 'Tempat Lahir',
            'tanggal_lahir' => 'Tanggal Lahir',
            'jenis_kelamin' => 'Jenis Kelamin',
            'agama' => 'Agama',
            'pendidikanterakhir' => 'Pendidikan Terakhir',
            'alamat_rumah' => 'Alamat Rumah',
            'nomor_npwp' => 'Nomor NPWP',
            'keterangan' => 'Keterangan',
            'waktu_daftar' => 'Tanggal Daftar',
            'waktu_update' => 'Tanggal Update',
            'waktu_login' => 'Tanggal Login',
            'waktu_approve' => 'Waktu Approve',
            'approved_by' => 'Approved By',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'verification_token' => 'Verification Token',
            'access_token' => 'Access Token',
            'expire_at' => 'Expire At'
        ];
    }

    /**
     * Gets query for [[Agama0]].
     *
     * @return \yii\db\ActiveQuery|VariabelAgamaQuery
     */
    public function getAgama()
    {
        return $this->hasOne(VariabelAgama::className(), ['agama' => 'agama']);
    }

    /**
     * Gets query for [[PendidikanTerakhir]].
     *
     * @return \yii\db\ActiveQuery|VariabelPendidikanterakhirQuery
     */
    public function getPendidikanTerakhir()
    {
        return $this->hasOne(VariabelPendidikanterakhir::className(), ['pendidikanterakhir' => 'pendidikanterakhir']);
    }

    /**
     * Gets query for [[Status0]].
     *
     * @return \yii\db\ActiveQuery|VariabelStatusQuery
     */
    public function getStatus()
    {
        return $this->hasOne(VariabelStatus::className(), ['status' => 'status']);
    }

    /**
     * Gets query for [[Statuskaryawan0]].
     *
     * @return \yii\db\ActiveQuery|VariabelStatuskaryawanQuery
     */
    public function getStatuskaryawan()
    {
        return $this->hasOne(VariabelStatuskaryawan::className(), ['statuskaryawan' => 'status_karyawan']);
    }

    /**
     * Gets query for [[Unit0]].
     *
     * @return \yii\db\ActiveQuery|VariabelUnitQuery
     */
    public function getUnit()
    {
        return $this->hasOne(VariabelUnit::className(), ['unit' => 'unit']);
    }

    public function getDbpegawaiPubPegawai()
    {
        return $this->hasOne(DbpegawaiPubPegawai::className(), ['pegKodeResmi' => 'nomor_pegawai']);
    }

    /**
     * Gets query for [[HistoriAnggotaStatuses]].
     *
     * @return \yii\db\ActiveQuery|HistoriAnggotaStatusQuery
     */
    public function getHistoriAnggotaStatuses()
    {
        return $this->hasMany(HistoriAnggotaStatus::className(), ['anggota_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AnggotaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AnggotaQuery(get_called_class());
    }

    public static function findAnggota()
    {
        return self::find()
            ->where(['kode_toko'=>Yii::$app->user->identity->kode_toko]);
    }

    public static function findOneAnggota($id)
    {
        return self::findAnggota()
            ->andWhere(['id'=>$id])
            ->one();
    }

    public static function findAnggotaAktif()
    {
        return self::findAnggota()
            ->andWhere('status = \'Aktif\' AND (nomor_anggota IS NOT NULL OR waktu_approve IS NOT NULL)');
    }

    public static function findOneAnggotaAktif($id)
    {
        return self::findAnggotaAktif()
            ->andWhere(['id'=>$id])
            ->one();
    }

    public static function findAnggotaAktifNonaktif()
    {
        return self::findAnggota()
            ->andWhere('status in (\'Aktif\',\'Non Aktif\') AND (nomor_anggota IS NOT NULL OR waktu_approve IS NOT NULL)');
    }

    public static function findOneAnggotaAktifNonaktif($id)
    {
        return self::findAnggotaAktifNonaktif()
            ->andWhere(['id'=>$id])
            ->one();
    }

    public static function findAnggotaByNomorAnggota($nomor_anggota)
    {
        return self::findAnggota()
            ->andwhere(['nomor_anggota'=>$nomor_anggota]);
    }

    public static function findOneAnggotaByNomorAnggota($nomor_anggota)
    {
        return self::findAnggotaByNomorAnggota($nomor_anggota)
            ->one();
    }

    public static function findAnggotaByNomorZahir($nomor_zahir)
    {
        return self::findAnggota()
            ->andwhere(['nomor_zahir'=>$nomor_zahir]);
    }

    public static function findOneAnggotaByNomorZahir($nomor_zahir)
    {
        return self::findAnggotaByNomorZahir($nomor_zahir)
            ->one();
    }

    public static function findFrontendAnggota()
    {
        return self::find()
            ->where(['kode_toko'=>Yii::$app->params['kode_toko']])
            ->andWhere(['id'=>Yii::$app->user->identity->id]);
    }

    public static function findOneFrontendAnggota()
    {
        return self::findFrontendAnggota()
            ->one();
    }

    public function sendEmail($anggota)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $anggota]
            )
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name . ' no-replay'])
            ->setTo($this->email)
            ->setSubject('Verifikasi Email ' . Yii::$app->name)
            ->send();
            exit();
    }
}
