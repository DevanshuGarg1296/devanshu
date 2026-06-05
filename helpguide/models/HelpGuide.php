<?php

namespace app\modules\helpguide\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "documentation_items".
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property int $order
 * @property string $status
 */
class HelpGuide extends ActiveRecord
{
    public static function tableName()
    {
        return 'documentation_items';
    }

      

    public static function getDb()
    {
        // tell Yii to use db2 instead of the default db
        return \Yii::$app->db2;
    }

    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['content'], 'string'],
            [['order'], 'integer'],
            [['status'], 'string', 'max' => 20],
            [['title', 'slug'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Auto-slug from title
            $this->slug = strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->title));
            if ($this->isNewRecord) {
                $this->order = 0;
                $this->status = 'active';
            }
            return true;
        }
        return false;
    }
}
