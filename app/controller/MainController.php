<?php
use Imy\Core\Controller;
use Imy\Core\Tools;
use Imy\Core\Model;

class MainController extends Controller
{
    protected $database = 'default';
    protected $model;
    protected $entity = 'review';

    function __construct()
    {
        $this->model = M('review', $this->database);
    }

    function init()
    {
        $reviews =$this->datatable([]);

        $this->v['reviews'] = $reviews['data'];
        
    }

    function ajax_test() {

        if(isset($_POST['name']) && !empty($_POST['name']) &&
            isset($_POST['message']) && !empty($_POST['message'])){

            $name = filter_var( $_POST['name'], FILTER_SANITIZE_STRING);
            $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
            $date = date("Y-m-d H:m:s");

            $reviews =$this->create([
                'name' => $name,
                'message' => $message,
                'date' => $date
            ]);
            $dateFormat = date_create($date);

            $this->success('Отзыв сохранен', [
                'name' => $name,
                'msg' => $message,
                'date' => date_format($dateFormat,"d-m-Y")
            ]);

        }else{
            $this->error('Заполните все поля формы');
        }
        
    }

    function getMany($field = [], $value = false, $order = false, $dir = 'ASC', $callback = false, $options = [])
    {

        $where = [];
        if (is_array($field)) {
            foreach ($field as $k => $v) {
                $where[$k] = $v;
            }
        } else {
            $where[$field] = $value;
        }


        $result = $this->model->get();
        foreach ($where as $k => $v) {
            if (is_array($v) && (isset($v['value']) || isset($v['sign']))) {
                $result = $result->where($k, $v['value'], $v['sign']);
            } else {
                $result = $result->where($k, $v);
            }

        }

        if ($callback) {
            $result = $callback($result);
        }

        if (!empty($order)) {
            $result = $result->orderBy($order, $dir);
        }

        $result = $result->fetchAll(!empty($options['die']));

        $class = get_class($this);

        $objects = [];
        foreach ($result as $item) {
            $objects[] = new $class($item);
        }

        return $objects;
    }

    function set($key, $val = false)
    {
        if (is_array($key)) {
            $this->info->setValues($key);
        } else {
            $this->info->setValue($key, $val);
        }

        return $this->info->save();
    }

    function datatable($opts,$callback = false,$countField = 'id') {

        $items = M($this->entity,$this->database)->get();

        $ct = $items->copy()->count($countField);

        $orderField = $opts['columns'][$opts['order'][0]['column']]['data'];
        $orderDir = $opts['order'][0]['dir'];

        if(!empty($opts['cond'])) {
            foreach($opts['cond'] as $k => $v) {
                if (is_array($v) && (isset($v['value']) || isset($v['sign']))) {
                    $items = $items->where($k, $v['value'], $v['sign']);
                } else {
                    $items = $items->where($k, $v);
                }
            }
        }

        if($callback) {
            $items = $callback($items);
        }

        $filtered = $items->copy()->count($countField);

        if(!empty($orderField)) {
            $items = $items->orderBy($orderField,strtoupper($orderDir));
        }
        else {
            $items = $items->orderBy('id','DESC');
        }

        if(!empty($opts['start']))
            $items->offset($opts['start']);

        if(!empty($opts['length']))
            $items->limit($opts['length']);

        $items = $items->fetchAll();

        $return = [];

        $return['draw'] = $opts['draw'] ?: 1;
        $return['recordsTotal'] = $ct;
        $return['recordsFiltered'] = $filtered;
        $return['data'] = $items;

        return $return;
    }

    function create($data)
    {
        $this->info = M($this->entity, $this->database)->factory();
        return $this->set($data);
    }
}
