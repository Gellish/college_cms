<?php

class EdusecRequirementChecker
{
    public function __construct()
    {
	$requirements = array(
	   array(
		'name' => 'Assets Directory Permission',
		'mandatory' => true,
		'condition' => is_writable(realpath(dirname(__FILE__).'/../assets')),
		'by' => '<a href="http://www.yiiframework.com">Yii Framework</a>',
		'memo' => 'Assets directory must be writable by the Web server process. </br><b>'.realpath(dirname(__FILE__).'/../assets').'</b>',
	    ),
	    array(
		'name' => 'Runtime Directory Permission',
		'mandatory' => true,
		'condition' => is_writable(realpath(dirname(__FILE__).'/../runtime')),
		'by' => '<a href="http://www.yiiframework.com">Yii Framework</a>',
		'memo' => 'Runtime directory must be writable by the Web server process.</br><b>'.realpath(dirname(__FILE__).'/../runtime').'</b>',
	    ),
	    array(
		'name' => 'Data Directory Permission',
		'mandatory' => true,
		'condition' => is_writable(realpath(dirname(__FILE__).'/../data')),
		'by' => 'EduSec',
		'memo' => 'Data directory must be writable by the Web server process.</br><b>'.realpath(dirname(__FILE__).'/../data').'</b>',
	    ),
	   array(
		'name' => 'Config Directory Permission',
		'mandatory' => true,
		'condition' => is_writable(realpath(dirname(__FILE__).'/../config')),
		'by' => 'EduSec',
		'memo' => 'Config directory must be writable by the Web server process.</br><b>'.realpath(dirname(__FILE__).'/../config').'</b>',
	    ),
	    array(
		'name' => 'PHP version',
		'mandatory' => true,
		'condition' => version_compare(PHP_VERSION, '5.4.0', '>='),
		'by' => 'EduSec/Yii Framework',
		'memo' => 'PHP 5.4.0 or higher is required.<br><b>Current PHP version : ' . phpversion() . '</b>',
	    ),
	    array(
		'name' => 'PDO extension',
		'mandatory' => true,
		'condition' => extension_loaded('pdo'),
		'by' => 'All DB-related classes',
	    ),
	    array(
		'name' => 'PDO MySQL extension',
		'mandatory' => true,
		'condition' => extension_loaded('pdo_mysql'),
		'by' => 'All DB-related classes',
		'memo' => 'Required for MySQL database.',
	    ),
	    array(
		'name' => 'Reflection extension',
		'mandatory' => true,
		'condition' => class_exists('Reflection', false),
		'by' => '<a href="http://www.yiiframework.com">Yii Framework</a>',
	    ),
	    array(
		'name' => 'PCRE extension',
		'mandatory' => true,
		'condition' => extension_loaded('pcre'),
		'by' => '<a href="http://www.yiiframework.com">Yii Framework</a>',
	    ),
	    array(
		'name' => 'SPL extension',
		'mandatory' => true,
		'condition' => extension_loaded('SPL'),
		'by' => '<a href="http://www.yiiframework.com">Yii Framework</a>',
	    ),
	    array(
		'name' => 'MBString extension',
		'mandatory' => true,
		'condition' => extension_loaded('mbstring'),
		'by' => '<a href="http://www.php.net/manual/en/book.mbstring.php">Multibyte string</a> processing',
		'memo' => 'Required for multibyte encoding string processing.'
	    ),	
	);
	$this->check($requirements);	
    }

    
 
    function check($requirements)
    {
        if (is_string($requirements)) {
            $requirements = require($requirements);
        }
        if (!is_array($requirements)) {
            $this->usageError('Requirements must be an array, "' . gettype($requirements) . '" has been given!');
        }

        if (!isset($this->result) || !is_array($this->result)) {
            $this->result = array(
                'summary' => array(
                    'total' => 0,
                    'errors' => 0,
                    'warnings' => 0,
                ),
                'requirements' => array(),
            );
        }

        foreach ($requirements as $key => $rawRequirement) {
            $requirement = $this->normalizeRequirement($rawRequirement, $key);
            $this->result['summary']['total']++;
            if (!$requirement['condition']) {
                if ($requirement['mandatory']) {
                    $requirement['error'] = true;
                    $requirement['warning'] = true;
                    $this->result['summary']['errors']++;
                } else {
                    $requirement['error'] = false;
                    $requirement['warning'] = true;
                    $this->result['summary']['warnings']++;
                }
            } else {
                $requirement['error'] = false;
                $requirement['warning'] = false;
            }
            $this->result['requirements'][] = $requirement;
        }

        return $this;
    }

    /**
     * Normalizes requirement ensuring it has correct format.
     * @param array $requirement raw requirement.
     * @param integer $requirementKey requirement key in the list.
     * @return array normalized requirement.
     */
    function normalizeRequirement($requirement, $requirementKey = 0)
    {
        if (!is_array($requirement)) {
            $this->usageError('Requirement must be an array!');
        }
        if (!array_key_exists('condition', $requirement)) {
            $this->usageError("Requirement '{$requirementKey}' has no condition!");
        } else {
            $evalPrefix = 'eval:';
            if (is_string($requirement['condition']) && strpos($requirement['condition'], $evalPrefix) === 0) {
                $expression = substr($requirement['condition'], strlen($evalPrefix));
                $requirement['condition'] = $this->evaluateExpression($expression);
            }
        }
        if (!array_key_exists('name', $requirement)) {
            $requirement['name'] = is_numeric($requirementKey) ? 'Requirement #' . $requirementKey : $requirementKey;
        }
        if (!array_key_exists('mandatory', $requirement)) {
            if (array_key_exists('required', $requirement)) {
                $requirement['mandatory'] = $requirement['required'];
            } else {
                $requirement['mandatory'] = false;
            }
        }
        if (!array_key_exists('by', $requirement)) {
            $requirement['by'] = 'Unknown';
        }
        if (!array_key_exists('memo', $requirement)) {
            $requirement['memo'] = '';
        }

        return $requirement;
    }

    function getResult()
    {
        if (isset($this->result)) {
            return $this->result;
        } else {
            return null;
        }
    }

    /**
     * Returns the server information.
     * @return string server information.
     */
    function getServerInfo()
    {
        $info = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '';

        return $info;
    }

    /**
     * Returns the now date if possible in string representation.
     * @return string now date.
     */
    function getNowDate()
    {
        $nowDate = @strftime('%Y-%m-%d %H:%M', time());

        return $nowDate;
    }
}
?>
