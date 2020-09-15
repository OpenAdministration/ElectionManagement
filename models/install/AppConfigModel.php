<?php


namespace app\models\install;


use Exception;
use Yii;
use yii\base\Model;
use yii\base\Security;
use yii\db\Connection;
use yii\helpers\StringHelper;
use yii\validators\DefaultValueValidator;

class AppConfigModel extends Model
{
    // names.php
    public string $adminMail = '';
    public string $senderMail = '';
    public string $senderName = '';

    public string $appName = '';
    public string $appId = '';

    // secrets.php
    public string $cookieValidationKey = '';

    public string $dbClass  = '';
    public string $dbEngine  = '';
    public string $dbHost  = '';
    public string $dbName = '';
    public int $dbPort = 0;
    public string $dbUser = '';
    public string $dbPassword = '';

    public function generateDnsString() : string {
        $db = [
            $this->dbEngine . ':dbname=' . $this->dbName,
            'host=' . $this->dbHost,
        ];
        if(isset($this->dbPort) && !empty($this->dbPort)){
            $db[] = 'port=' . $this->dbPort;
        }
        return implode(';', $db);
    }

    public function save() : bool {
        // TODO: test me
        $namesSample = file_get_contents(Yii::$app->basePath . '/config/names.sample.php');
        $secretsSample = file_get_contents(Yii::$app->basePath . '/config/secrets.sample.php');
        $attributes = $this->getAttributes();
        $attributes['dns'] = $this->generateDnsString();
        $attributeNames = array_keys($attributes);
        array_walk($attributeNames, static function (&$val){
            $val = "\<" . $val . "\>";
        });
        Yii::debug($attributeNames);
        $namesContent = str_replace($attributeNames, array_values($attributeNames), $namesSample);
        $secretsContent = str_replace($attributeNames, array_values($attributeNames), $secretsSample);
        file_put_contents(Yii::$app->basePath . '/config/names.php', $namesContent);
        file_put_contents(Yii::$app->basePath . '/config/secrets.php', $secretsContent);

        return true;
    }

    public function rules() : array
    {
        // https://www.yiiframework.com/doc/api/2.0/yii-base-model#rules()-detail
        // https://www.yiiframework.com/doc/guide/2.0/en/input-validation
        $allVars = $this->attributes();
        $random = Yii::$app->getSecurity()->generateRandomString();
        return [
            [array_diff($allVars, ['dbHost', 'cookieValidationKey', 'dbClass']), 'default'],
            ['dbHost', 'default', 'value' => 'localhost'],
            ['dbClass', 'default', 'value' => Connection::class],
            ['cookieValidationKey', 'default', 'value' => $random],
            [array_diff($allVars, ['dbPort', 'cookieValidationKey', 'dbClass', 'dbHost']), 'required'],
            [array_diff($allVars, ['dbPort', 'adminMail', 'senderMail']), 'string'],
            [['adminMail', 'senderMail'], 'email'],
            [array_diff($allVars, ['dbPort']), 'trim'],
            ['dbPort', 'integer', 'min' => 1, 'max' => 65535],
            ['dbEngine', 'in', 'range' => $this->listDbEngines()]
        ];
    }

    public function listDbEngines(bool $keyMirror = false) : array {
        $supported = ['mysql'];
        //TODO: find all engines which  are supported by pdo / ...
        if($keyMirror !== false) {
            return array_combine($supported, $supported);
        }
        return $supported;
    }

    public function listDbClasses(bool $keyMirror = false) : array {
        $supported = [Connection::class];
        //TODO: find all engines which  are supported
        if($keyMirror !== false) {
            return array_combine($supported, $supported);
        }
        return $supported;
    }

    public function beforeValidate() : bool
    {
        $dbConnectable = true;//$this->validateDbConnection();
        if(!$dbConnectable){
            $this->addError('dbPassword', 'No Connection');
            return false;
        }
        return true;
    }

    public function validateDbConnection() :bool {
        try{
            $connection = new $this->dbClass([
              'dsn' => $this->generateDnsString(),
              'username' => $this->dbUser,
              'password' => $this->dbPassword,
            ]);
            $connection->open();
        }catch (Exception $exception){
            return false;
        }
        return true;
    }

    public function attributeLabels() : array
    {
        //TODO: Complete and translate
        return [
            'adminMail' => 'Mail Administrator*in'
        ];
    }




}