<?php

namespace common\models;

use Yii;
use yii\rbac\Item;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * AuthBase extends from class Item
 *
 * @author Hendi Andriansah <coldweaker@gmail.com>
 */
class AuthBase extends Item
{
    /**
     * Assign value of attribute model to object Item
     *
     * @param $auth component authManager
     * @param $type string type of item
     * @param $model \app\models\Model
     * @return Object Item
     */
    public static function createItemByModel($auth, $type, Model $model)
    {
        if ($type == static::TYPE_ROLE) {
            $object = $auth->createRole($model->name);
        } else {
            $object = $auth->createPermission($model->name);
        }
        $object->description = !empty($model->description) ? $model->description : null;
        $object->ruleName = !empty($model->rule_name) ? $model->rule_name : null;
        $object->data = !empty($model->data) ? $model->data : null;

        return $object;
    }

    /**
     * @return array roles and permission
     */
    public static function getItems()
    {
        $auth = Yii::$app->authManager;
        $roles = ArrayHelper::map($auth->getRoles(static::TYPE_ROLE), 'name', 'name');
        $permissions = ArrayHelper::map($auth->getPermissions(static::TYPE_PERMISSION), 'name', 'name');
        $items = ArrayHelper::merge($roles, $permissions);
        return $items;
    }

    /**
     * @return array items belongs to other item and not 
     */
    public static function getArrayChilds($parent)
    {
        $items = static::getItems();
        $hasChilds = ArrayHelper::map(Yii::$app->authManager->getChildren($parent), 'name', 'name');
        $childs = array_diff($items, $hasChilds);
        if (isset($childs[$parent])) {
            unset($childs[$parent]);
        }
        return ['hasChilds' => $hasChilds, 'childs' => $childs];
    }

    /**
     * Get item by name
     *
     * @param string $name
     * @return Role or Permission objet or null
     */
    public static function getItem($name)
    {
        $auth = Yii::$app->authManager;
        $item = $auth->getRole($name);
        if ($item === null) {
            $item = $auth->getPermission($name);
        }
        return $item;
    }

    /**
     * Add childs to parent
     *
     * @param string $parentName
     * @param array $childNames
     * @return array result data saved or failed with their messages
     */
    public static function addChilds($parentName, $childNames)
    {
        $auth = Yii::$app->authManager;
        $parent = static::getItem($parentName);
        $arrSaved = $arrFailed = $arrMessageFailed = $arrMessageSaved = [];
        if ($parent !== null && is_array($childNames)) {
            foreach ($childNames as $key => $childName) {
                $child = static::getItem($childName);
                try {
                    $auth->addChild($parent, $child);
                    $arrSaved[$child->name] = $child->name;
                    $arrMessageSaved[$child->name] = $child->name . " success to save.";
                } catch (\BadMethodCallException $bce) {
                    $arrFailed[$childName] = $childName;
                    $arrMessageFailed[$childName] = "$childName : " . strtolower($bce->getMessage());
                } catch (\Exception $e) {
                    $arrFailed[$childName] = $childName;
                    $arrMessageFailed[$childName] = "$childName : failed to save.";
                }
            }
        }
        return [
            'saved' => $arrSaved,
            'failed' => $arrFailed,
            'message' => [
                'saved' => $arrMessageSaved,
                'failed' => $arrMessageFailed
            ]
        ];
    }

    /**
     * Remove childs from parent
     *
     * @param string $parentName
     * @param array $childNames
     * @return array result data removed or failed with their messages
     */
    public static function removeChilds($parentName, $childNames)
    {
        $auth = Yii::$app->authManager;
        $parent = static::getItem($parentName);
        $arrRemoved = $arrFailed = $arrMessageFailed = $arrMessageRemoved = [];
        if ($parent !== null && is_array($childNames)) {
            foreach ($childNames as $key => $childName) {
                $child = static::getItem($childName);
                try {
                    $auth->removeChild($parent, $child);
                    $arrRemoved[$child->name] = $child->name;
                    $arrMessageRemoved[$child->name] = $child->name . " success to remove.";
                } catch (\BadMethodCallException $bce) {
                    $arrFailed[$childName] = $childName;
                    $arrMessageFailed[$childName] = "$childName : " . strtolower($bce->getMessage());
                } catch (\Exception $e) {
                    $arrFailed[$childName] = $childName;
                    $arrMessageFailed[$childName] = "$childName : failed to remove.";
                }
            }
        }
        return [
            'removed' => $arrRemoved,
            'failed' => $arrFailed,
            'message' => [
                'removed' => $arrMessageRemoved,
                'failed' => $arrMessageFailed
            ]
        ];
    }

    /**
     * Remove assignment by specific user id
     *
     * @return boolean
     */
    public static function removeAssignmentByUser($userId)
    {
        $auth = Yii::$app->authManager;
        return $auth->db->createCommand()
            ->delete($auth->assignmentTable, ['user_id' => $userId])
            ->execute() > 0;
    }

    /**
     * @return array $dirtyRoles
     */
    public static function mapRoles($dirtyRoles)
    {
        $roles = ArrayHelper::map($dirtyRoles, 'name', 'name');
        array_walk($roles, function(&$value) {
            $value = Inflector::camel2words($value);
        });
        return $roles;
    }
}
