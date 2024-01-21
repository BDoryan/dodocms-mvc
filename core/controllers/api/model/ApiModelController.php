<?php

class ApiModelController extends ApiController
{

    public function getTable($table_name): ?Table
    {
        $table = Table::getTable($table_name);
        if (!isset($table)) {
            $this->error('table_not_found', ['table' => $table_name]);
            return null;
        }
        return $table;
    }

    public function getModel(Table $table): ?Model
    {
        $model = $table->getModel();
        if (!isset($model)) {
            $this->error('model_not_found', ['model' => $table->getName()]);
            return null;
        }
        return $model;
    }

    public function getForm($params)
    {
        $table_name = $params['model'];
        $table = $this->getTable($table_name);
        if (!isset($table))
            return;

        $model = $this->getModel($table);
        if (!isset($model))
            return;

        $entry_id = $_GET['id'] ?? null;

        if (isset($entry_id)) {
            if ($model->id($entry_id)->fetch() == null) {
                $this->error('entry_not_found', ['id' => $entry_id]);
                return;
            }
        }

        echo fetch(Application::get()->toRoot("/core/views/admin/panel/sections/table/entry/set_form.php"), ['model' => $model, 'show_buttons' => false]);
    }

    public function deleteEntry($params)
    {
        $table_name = $params['model'];
        $table = $this->getTable($table_name);
        if (!isset($table)) {
            $this->error('table_not_found', ['table' => $table_name]);
            return;
        }

        $model = $this->getModel($table);
        if (!isset($model)) {
            $this->error('model_not_found', ['model' => $table->getName()]);
            return;
        }

        $entry_id = $params['id'] ?? null;

        try {
            if ($model->id($entry_id)->fetch() == null) {
                $this->error('entry_not_found', ['id' => $entry_id]);
                return;
            }

            if ($model->delete()) {
                $this->success('entry_delete_success', ['model' => $model->toArray(), 'id' => $model->getId()]);
            } else {
                $this->error('entry_delete_error', ['model' => $model->getTableName(), 'id' => $entry_id]);
            }
        } catch (Exception $e) {
            Application::get()->getLogger()->error("Error while setting entry");
            Application::get()->getLogger()->printException($e);
            $this->error('entry_set_error', ['model' => $model->getTableName(), 'id' => $entry_id]);
        }
    }

    public function setEntry($params)
    {
//        echo "<pre>";
//        var_dump($_POST);
//        exit;

        $table_name = $params['model'];
        $table = $this->getTable($table_name);
        if (!isset($table))
            return;

        $model = $this->getModel($table);
        if (!isset($model))
            return;

        $entry_id = $params['id'] ?? null;

        try {
            if (isset($entry_id)) {
                if ($model->id($entry_id)->fetch() == null) {
                    $this->error('entry_not_found', ['id' => $entry_id]);
                    return;
                }
            }

            $post_data = array_slice($_POST, 0);

            foreach ($post_data as $key => $value) {
                if (strpos($value, '<br type="_moz">') !== false)
                    $post_data[$key] = str_replace('<br type="_moz">', '', $value);
            }

            if (!empty($post_data)) {
                if (isset($entry_id))
                    $model->id($entry_id);

                $model->hydrate($post_data);
                if (isset($entry_id) ? $model->update() : $model->createAndFetch()) {
                    $this->success('entry_set_success', ['model' => $model->toArray(), 'id' => $model->getId()]);
                } else {
                    $this->error('entry_set_error', ['model' => $model->getTableName(), 'id' => $entry_id]);
                }
                return;
            }
        } catch (Exception $e) {
            Application::get()->getLogger()->error("Error while setting entry");
            Application::get()->getLogger()->printException($e);
            $this->error('entry_set_error', ['model' => $model->getTableName(), 'id' => $entry_id]);
        }
    }

}