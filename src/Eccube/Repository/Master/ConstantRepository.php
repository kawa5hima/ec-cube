<?php

namespace Eccube\Repository\Master;

use Doctrine\ORM\EntityRepository;

/**
 * ConstantRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ConstantRepository extends EntityRepository
{
    /**
     * getAll
     * configにEC-CUBE2の設定を入れる。暫定メソッド。
     * 
     * @return array
     */
    public function getAll()
    {
        $return = array();

        if (!defined('HTML_REALDIR')) {
            $GLOBALS['_realdir'] = rtrim(realpath(rtrim(realpath(dirname(__FILE__)), '/\\') . '/'), '/\\') . '/';
            $GLOBALS['_realdir'] = str_replace('\\', '/', $GLOBALS['_realdir']);
            $GLOBALS['_realdir'] = str_replace('//', '/', $GLOBALS['_realdir']);
            define('HTML_REALDIR', $GLOBALS['_realdir']);
        }
        if (!defined('HTML2DATA_DIR')) {
            define('HTML2DATA_DIR', '../data/');
        }
        if (!defined('DATA_REALDIR')) {
            define('DATA_REALDIR', HTML_REALDIR . HTML2DATA_DIR);
        }
        if (!defined('DIR_INDEX_PATH')) {
            define('DIR_INDEX_PATH', '');
        }

        require_once __DIR__ . '/../../../../app/config/eccube/config.php';
        require_once __DIR__ . '/../../../../app/mtb_constants_init.php';

        /* @var $Constants \Eccube\Entity\Master\Constant[] */
        $Constants = $this->findAll();
        foreach ($Constants as $Constant) {
            $return[strtolower($Constant->getId())] = eval('return ' . $Constant->getName() . ';');
        }

        return $return;
    }
}
