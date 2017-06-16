<extend name="../../Admin/View/Common/base_layout"/>

<block name="content">
    <div style="background-color: #ecf0f5;height: 100%;display: none;" id="app">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">新增Checker</h3>
                            <section style="margin-top: 8px;">
                                <div class="row">

                                </div>

                            </section>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <form class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">URL</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control"  v-model.trim="url">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">频率（分钟/次）</label>

                                        <div class="col-sm-10">
                                            <input type="number" step="1" min="1" class="form-control" v-model="minute">
                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label class="col-sm-2 control-label">使用状态</label>

                                        <div class="col-sm-10">
                                            <div class="radio" style="display: inline-block;">
                                                <label>
                                                    <input type="radio" name="enable" :value="1" v-model="enable">
                                                    启用
                                                </label>
                                            </div>

                                            <div class="radio" style="display: inline-block;">
                                                <label>
                                                    <input type="radio" name="enable" :value="0"  v-model="enable">
                                                    禁用
                                                </label>
                                            </div>

                                        </div>
                                    </div>



                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="button" class="btn btn-primary pull-left" @click="doConfirm">确认</button>
                                </div>
                                <!-- /.box-footer -->
                            </form>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->


                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

        <section style="display: none">
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                        </div>
                    </div>
                </div>
            </section>
        </section>




    </div>

    <script>
        $(document).ready(function(){
            var App = new Vue({
                el: '#app',
                data:{
                    id: "{:I('get.checker_id', '')}",
                    url: "<?php echo !isset($data['url'])? '':$data['url']; ?>",
                    minute: "<?php echo !isset($data['minute'])? '5':$data['minute']; ?>",
                    enable: "<?php echo !isset($data['enable'])? '1':$data['enable']; ?>"
                },
                mounted: function(){
                    $('#app').show();
                },
                computed: {
                  isEnable: function(){
                      if(this.enable == 0){
                          return false;
                      }else{
                          return true;
                      }
                  }
                },
                methods: {
                    //关闭layer窗口
                    closeLayer: function(){
                        var index = window.parent.layer.getFrameIndex(window.name); //获取窗口索引
                        parent.layer.close(index);
                    },
                    //请求获取数据列表
                    doConfirm: function () {
                        var that = this;
                        var data = {
                            id: that.id,
                            url: that.url,
                            minute: that.minute,
                            enable: that.enable
                        };
                        var req_url = '';
                        if(that.id === ''){
                            req_url = "{:U('Mirror/Index/do_create_checker')}";
                        }else{
                            req_url = "{:U('Mirror/Index/do_edit_checker')}";
                        }
                        $.ajax({
                            url: req_url,
                            type: 'post',
                            dataType: 'json',
                            data: data,
                            success: function (res) {
                                if (res.status) {
                                    layer.msg('操作完成');
                                    setTimeout(function(){
                                        window.location.reload();
                                    }, 700);

                                } else {
                                    layer.msg(res.msg);
                                }
                            }, error: function () {
                                layer.msg('网络繁忙，请稍后再试')
                            }
                        });
                    },

                    /**
                     * 解析url
                     * @param url
                     * @returns {{protocol, host: (*|string), hostname: (*|string), pathname: (*|string), search: {}, hash}}
                     */
                    parserUrl: function (url) {
                        var a = document.createElement('a');
                        a.href = url;

                        var search = function (search) {
                            if (!search) return {};

                            var ret = {};
                            search = search.slice(1).split('&');
                            for (var i = 0, arr; i < search.length; i++) {
                                arr = search[i].split('=');
                                var key = arr[0], value = arr[1];
                                if (/\[\]$/.test(key)) {
                                    ret[key] = ret[key] || [];
                                    ret[key].push(value);
                                } else {
                                    ret[key] = value;
                                }
                            }
                            return ret;
                        };

                        return {
                            protocol: a.protocol,
                            host: a.host,
                            hostname: a.hostname,
                            pathname: a.pathname,
                            search: search(a.search),
                            hash: a.hash
                        }
                    },
                },
            });
        });

    </script>


</block>