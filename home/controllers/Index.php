<?php
/**
 * 默认控制器
 */

use Elasticsearch\ClientBuilder;

class IndexController extends BaseController {

	/** 
     * 默认动作
     */
	public function indexAction($name = "home") {/*{{{*/
		//1. fetch query
		$get = $this->getRequest()->getQuery("get", "default value");

		//2. fetch model
		$model = new Home_SampleModel();

		//3. assign
		$this->getView()->assign("content", $model->selectSample());
		$this->getView()->assign("name", $name);

        // $this->setCrontab();
        // $this->delCrontab();

		//4. render by Yaf, 如果这里返回FALSE, Yaf将不会调用自动视图引擎Render模板
        return TRUE;
	}/*}}}*/

    public function setCrontab() {/*{{{*/
        $crontab = new CrontabManager();
        $job = $crontab->newJob();
        $job->on('* * * * *');
        $job->onMinute('20-30')->doJob("echo foo");
        $crontab->add($job);
        $job->onMinute('35-40')->doJob("echo bar");
        $crontab->add($job);
        $crontab->save();
    }/*}}}*/

    public function delCrontab() {/*{{{*/
        $crontab = new CrontabManager();
        $crontab->enableOrUpdate('/tmp/cronfile.txt');
        // $crontab->disable('/tmp/cronfile.txt');
        $crontab->save();
    }/*}}}*/

    public function elsSetAction() {
        $client = Elasticsearch\ClientBuilder::create()->build(); 
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id',
            'body' => ['testField' => 'abc']
        ];

        $response = $client->index($params);
        print_r($response);
        return false;
    }

    public function elsGetAction() {
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id'
        ];
        $client = Elasticsearch\ClientBuilder::create()->build(); 
        $response = $client->get($params);
        print_r($response);

        return false;
    }

    public function elsSearchAction() {
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'body' => [
                'query' => [
                    'match' => [
                        'testField' => 'abc'
                    ]
                ]
            ]
        ];

        $client = Elasticsearch\ClientBuilder::create()->build(); 
        $response = $client->search($params);
        print_r($response);

        return false;
    }

    public function elsDelAction() {
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id'
        ];

        $client = Elasticsearch\ClientBuilder::create()->build(); 
        $response = $client->delete($params);
        print_r($response);

        return false;
    }

}
