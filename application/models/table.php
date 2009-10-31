<?php
abstract class Table_Model extends ORM
{
    public $headers;

    public function __construct($id = NULL)
    {
        parent::__construct($id);
    }

    public function table_columns ()
    {
        $columns = array();
        foreach ($this->headers as $header)
        {
            if (in_array($header, $this->belongs_to))
            {
                $column = new Column_Item($header, $header . '_id', TRUE);
                $column->link = TRUE;
            } else
            {
                $column = new Column_Item($header);
                if ($header == $this->primary_val or $header == $this->primary_key)
                {
                    $column->link = TRUE;
                }
            }
            array_push($columns, $column);
        }
        return $columns;
    }

    public function table_view($per_page = NULL, $offset = NULL)
    {
        if (is_null($per_page) AND is_null($offset)) {
            $this->find_all();
        }
        return $this->find_all($per_page,$offset);
    }

    public function count_table_view() {
        return $this->count_all();
    }

    public function search($pattern, & $count, $limit = 20, $offset = 0)
    {
        $count = $this->like($this->primary_val, $pattern)
            ->count_all();
        $result = $this->like($this->primary_val, $pattern)
            ->find_all($limit,$offset);
        return $result;
    }

    public function __set($key, $value)
    {
    // TODO elegantnejsi prace s cizim klicem
        if ($this->is_related(str_replace('_id', '', $key)) AND $value == 0)
        {
            $value = '';
        }
        if ($value == '')
        {
            $value = NULL;
        }
        parent::__set($key, $value);
    }

    public function __toString ()
    {
        return (string) $this->{$this->primary_val};
    }

    public function is_related ($column)
    {
        return (boolean) in_array($column, $this->belongs_to);
    }

    /**
     *
     */
    public function find_insert ($default_value, $values = NULL)
    {
        $column = $this->primary_val;
        $model = ORM::factory($this->object_name)->where($column, $default_value)->find();

        if (empty($model->{$column}))
        {
            $model->{$column} = $default_value;
            if ( ! is_null($values))
            {
                foreach ($values as $key => $value)
                {
                    $model->{$key} = $value;
                }
            }
            return $model->save();
        } else
        {
            return $model;
        }
    }

    public function unique_key($id = NULL)
    {
        if ( ! empty($id) AND is_string($id) AND ! ctype_digit($id) )
        {
            return $this->primary_val;
        }
        return parent::unique_key($id);
    }
}
?>