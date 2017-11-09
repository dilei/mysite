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
        $contents = [
            ["_source" => ["title" => "yaceshuju1", "content" => "yacecontent"]], 
            ["_source" => ["title" => "yaceshuju2", "content" => "yacecontent"]], 
            ["_source" => ["title" => "yaceshuju3", "content" => "yacecontent"]], 
            ["_source" => ["title" => "yaceshuju4", "content" => "yacecontent"]], 
            ["_source" => ["title" => "yaceshuju5", "content" => "yacecontent"]], 
            ["_source" => ["title" => "yaceshuju6", "content" => "yacecontent"]], 
            ["_source" => ["title" => "yaceshuju7", "content" => "yacecontent"]], 
            ["_source" => ["title" => "yaceshuju8", "content" => "yacecontent"]], 
        ];
		$this->getView()->assign("contents", $contents);
        return true;

		//1. fetch query
		$get = $this->getRequest()->getQuery("get", "default value");

		//2. fetch model
		$model = new Home_SampleModel();

		//3. assign
		$this->getView()->assign("content", $model->selectSample());
		$this->getView()->assign("name", $name);

        // $this->setCrontab();
        // $this->delCrontab();

        $params = [
            'index' => 'php',
            'type' => 'blog',
            'body' => [
                'query' => [
                    'match' => [
                        'content' => 'search'
                    ]
                ]
            ]
        ];
        $contents = $this->elsSearch($params);
        if ($contents["hits"]["total"] > 0) {
            $this->getView()->assign("contents", $contents["hits"]["hits"]);
        } else {
            $this->getView()->assign("contents", "");
        }

		//4. render by Yaf, 如果这里返回FALSE, Yaf将不会调用自动视图引擎Render模板
        return TRUE;
	}/*}}}*/

    public function aboutAction() {
    }

    public function getallAction() {/*{{{*/
        if (!file_exists(APPLICATION_PATH."/public/search.xml") || filesize(APPLICATION_PATH."/public/search.xml") == 0) {
            $doc = new DOMDocument('1.0','UTF-8');
            $doc->formatOutput=true;               #设置可以输出操作  

            #声明根节点，最好一个XML文件有个跟节点  
            $root=$doc->createElement("search");    #创建节点对象实体   
            $root=$doc->appendChild($root);      #把节点添加进来  

            for($i=1;$i<100;$i++){  //循环生成节点，如果数据库调用出来就改这里  

                $info=$doc->createElement("entry");  #创建节点对象实体  
                $info=$root->appendChild($info);    #把节点添加到root节点的子节点  

                $title = $doc->createElement("title");    #创建节点对象实体         
                $title = $info->appendChild($title);  
                $title->appendChild($doc->createTextNode("title".$i));  #createTextNode创建内容的子节点，然后把内容添加到节点中来  

                $url = $doc->createElement("url");  
                $url = $info->appendChild($url);  
                $url->appendChild($doc->createTextNode("url".$i)); #注意要转码对于中文，因为XML默认为UTF-8格式  

                $content  = $doc->createElement("content");  
                $content  = $info->appendChild($content);  
                $content->appendChild($doc->createTextNode("content".$i)); #注意要转码对于中文，因为XML默认为UTF-8格式  

                $namevalue = $doc->createAttribute("type");  #创建节点属性对象实体   
                $namevalue = $content->appendChild($namevalue);  #把属性添加到节点info中  
                $namevalue->appendChild($doc->createTextNode("text"));  

            }     
            $doc->save(APPLICATION_PATH."/public/search.xml"); #保存路径  
        }

        header("Content-type: text/xml");
        echo file_get_contents(APPLICATION_PATH."/public/search.xml");
        return false;
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

    public function elsSetAction() {/*{{{*/
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
    }/*}}}*/

    public function elsBlukAction() {/*{{{*/
        $client = Elasticsearch\ClientBuilder::create()->build(); 

        //bulk批量生成  
        $bulk = array('index'=>'php','type'=>'blog');  
        for($i = 1; $i <= 1000; $i ++) {  
            $bulk['body'][]=array(  
                'index' => array(  
                    '_id'=>$i  
                ),  
            );  

            $bulk['body'][] = array(  
                'title'   => "els get started",  
                'url'     => 'https://idilei.com',  
                'content' => "Elasticsearch is a highly scalable open-source full-text search 
                and analytics engine. It allows you to store, search, and analyze big volumes 
                of data quickly and in near real time. It is generally used as the underlying 
                engine/technology that powers applications that have complex search features 
                and requirements.",  
            );  
        }  
        $response = $client->bulk($bulk);  
        print_r($response);
        return false;
    }/*}}}*/

    public function elsGetOne($index, $type, $id) {/*{{{*/
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id'
        ];
        $client = Elasticsearch\ClientBuilder::create()->build(); 
        $response = $client->get($params);
        print_r($response);

        return $response;
    }/*}}}*/

    public function elsMGet($params) {/*{{{*/
        $client = Elasticsearch\ClientBuilder::create()->build(); 
        $response = $client->mget($params);

        return $response;
    }/*}}}*/

    public function elsSearch($params) {
     
        $client = Elasticsearch\ClientBuilder::create()->build(); 
        $response = $client->search($params);

        return $response;
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
