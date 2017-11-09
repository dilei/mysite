define(['jquery', "bootstrap"], function($) {
    var module = {
        isfetched:false,
        init: function() {
            $(document).on('click', '.toolbar-handle', function() {
                var handle = $(this).data('handle');
                if(module['handle'] && typeof module['handle'][handle] == 'function'){
                    module['handle'][handle](this);
                }
            });

            // $(document).on("keydown", "#search_input", function(event) {
            //     $("#search_contents").html("");
            //     $("#search_contents").append("121212121");
            // });

            $('#myModal').on('show.bs.modal', function (e) {//{{{
                if (module.isfetched == false) {
                    $.ajax({
                        url: "/mysite/index/getall",
                        dataType: "xml",
                        async: true,
                        success: function( xmlResponse ) {
                            // get the contents from search data
                            module.isfetched = true;
                            var datas = $( "entry", xmlResponse ).map(function() {
                                return {
                                    title: $( "title", this ).text(),
                                    content: $("content",this).text(),
                                    url: $( "url" , this).text()
                                };
                            }).get();
                            var $input = document.getElementById("search_input");
                            var $resultContent = document.getElementById("search_contents");
                            $input.addEventListener('input', function(){//{{{
                                var matchcounts = 0;
                                var str='<ul class=\"search-result-list\">';                
                                var keywords = this.value.trim().toLowerCase().split(/[\s\-]+/);
                                $resultContent.innerHTML = "";
                                if (this.value.trim().length > 1) {
                                    // perform local searching
                                    datas.forEach(function(data) {
                                        var isMatch = true;
                                        var content_index = [];
                                        var data_title = data.title.trim().toLowerCase();
                                        var data_content = data.content.trim().replace(/<[^>]+>/g,"").toLowerCase();
                                        var data_url = data.url;
                                        var index_title = -1;
                                        var index_content = -1;
                                        var first_occur = -1;
                                        // only match artiles with not empty titles and contents
                                        if(data_title != '' && data_content != '') {
                                            keywords.forEach(function(keyword, i) {
                                                index_title = data_title.indexOf(keyword);
                                                index_content = data_content.indexOf(keyword);
                                                if( index_title < 0 && index_content < 0 ){
                                                    isMatch = false;
                                                } else {
                                                    if (index_content < 0) {
                                                        index_content = 0;
                                                    }
                                                    if (i == 0) {
                                                        first_occur = index_content;
                                                    }
                                                }
                                            });
                                        }
                                        // show search results
                                        if (isMatch) {
                                            matchcounts += 1;
                                            str += "<li><a href='"+ data_url +"' class='search-result-title'>"+ data_title +"</a>";
                                            var content = data.content.trim().replace(/<[^>]+>/g,"");
                                            if (first_occur >= 0) {
                                                // cut out 100 characters
                                                var start = first_occur - 20;
                                                var end = first_occur + 80;
                                                if(start < 0){
                                                    start = 0;
                                                }
                                                if(start == 0){
                                                    end = 50;
                                                }
                                                if(end > content.length){
                                                    end = content.length;
                                                }
                                                var match_content = content.substring(start, end);
                                                // highlight all keywords
                                                keywords.forEach(function(keyword){
                                                    var regS = new RegExp(keyword, "gi");
                                                    match_content = match_content.replace(regS, "<b class=\"search-keyword\">"+keyword+"</b>");
                                                });

                                                str += "<p class=\"search-result\">" + match_content +"...</p>"
                                            }
                                            str += "</li>";
                                        }
                                    })};
                                str += "</ul>";
                                if (matchcounts == 0) { str = '<div id="no-result"><i class="fa fa-frown-o fa-5x" /></div>' }
                                if (keywords == "") { str = '<div id="no-result"><i class="fa fa-search fa-5x" /></div>' }
                                $resultContent.innerHTML = str;
                            });//}}}
                        },
                    });
                }
            });//}}}

            // 链接websocket服务
            var wsl= 'ws://120.77.213.24:9501',
                ws = new WebSocket(wsl);//新建立一个连接

            // 事件绑定
            ws.onopen = function(){ws.send('Test!'); };  
            ws.onmessage = function(evt){console.log(evt.data);/*ws.close();*/};  
            ws.onclose = function(evt){console.log('WebSocketClosed!');};  
            ws.onerror = function(evt){console.log('WebSocketError!');}; 

        },

        handle: {
            search: function() {
                alert("hello");
            }
        }

    };

    return module;
});
