<?php



namespace app\models;
use Yii;
use yii\base\Model;

/**
 * This is the model class for use only installation.
 */
class Installation extends Model
{
    public $db_host, $db_user, $db_name, $db_password;
    public $is_demo_db, $is_agree;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['db_host', 'db_user', 'db_name'], 'required', 'on'=>'dbConfig'],
	    [['db_password'], 'safe', 'on'=>'dbConfig'],
	    [['is_demo_db'], 'required', 'on'=>'dbImport', 'message'=> Yii::t('app', 'Please select atleast one database')],
	    ['is_agree', 'required', 'on' => 'agree', 'requiredValue' => 1, 'message' => Yii::t('app', 'Please agree terms and conditions')],
	    [['db_password'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'db_host' => 'Database host',
            'db_user' => 'Database user',
	    'db_password' => 'Database password',
	    'db_name' => 'Database name',
	    'is_demo_db'=> 'Select Database',
	    'is_agree'=> 'I agree to these conditions?',
        ];
    }

    /**
     * @Check database connection and create database if any error is occurred to return error 
     * @return $dbResults;
     */
    public static function dbSetup($servername, $username, $password, $dbname)
    {
	try {
		$conn = new \PDO("mysql:host=$servername", $username, $password);
		$conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$conn->exec("CREATE DATABASE {$dbname} DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci") or die(print_r($dbh->errorInfo(), true));
		$dbResults = ['status'=>true, 'message'=>'Database setup successfully', 'data'=>$conn];
	}
	catch(\PDOException $e) {
		$dbResults = ['status'=>false, 'message'=>"<b>Error in database settings : </b><br>" . $e->getMessage(), 'data'=>false];
	}
	
	return $dbResults;
    }

    /**
     * @Check db file is create if create return db file content
     */
    public static function getDbConfig()
    {
        $dbConfigPath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR.'db.php';
	if(!file_exists($dbConfigPath)) {
		$results = ['status'=>false, 'message'=>'File is not found : '.$dbConfigPath,  'data'=>false];
	} else {
		$results = ['status'=>true, 'message'=>'Records Get Successfully', 'data'=>@include($dbConfigPath)];
	}

	return $results;
    }

    /**
     * @Get current connected database information into db.php
     */
    public static function initDb()
    {
	$db = NULL;
	$dbFileInfo = self::getDbConfig();
	if($dbFileInfo['status']) {
		$db = new \yii\db\Connection([
			'dsn' => $dbFileInfo['data']['dsn'],
			'username' => $dbFileInfo['data']['username'],
			'password' => $dbFileInfo['data']['password'],
			'charset' => $dbFileInfo['data']['charset'],
			'enableSchemaCache' => $dbFileInfo['data']['enableSchemaCache'],
		]);
	}
	return $db;
    }

    /**
     * @import edusec database
     */
    public static function dbImport($is_demo_db = false)
    {
	if($is_demo_db) {
		$dbPath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR.'edusec-sample-db.sql';
	} else {
		$dbPath = Yii::getAlias('@webroot') . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR.'edusec-empty-db.sql';
	}

	if(!file_exists($dbPath)) {
		$results = ['status'=>false, 'message'=>'File is not found : '.$dbPath];
	} else {
		$dbData = file_get_contents($dbPath);
		$command = Yii::$app->db->createCommand($dbData);
		$exResults = $command->execute();
		$results = ['status'=>true, 'message'=>$exResults];
	}

	return $results;	

    }

}
