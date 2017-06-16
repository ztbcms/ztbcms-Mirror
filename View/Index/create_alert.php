<extend name="../../Admin/View/Common/base_layout"/>

<block name="content">
    <div style="background-color: #ecf0f5;height: 100%;display: none;" id="app">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <?php $_alert_id = I('get.alert_id'); ?>
                            <h3 class="box-title"><if condition="empty($_alert_id)">新增<else/>编辑</if> Alert</h3>
                            <section style="margin-top: 8px;">
                                <div class="row">

                                </div>

                            </section>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <form class="form-horizontal">
                                <div class="box-body">
                                    <div class="form-group" style="display: none;">
                                        <label class="col-sm-2 control-label">Alert ID</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="" class="form-control" v-model="id">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">通知类型</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" v-model="type">
                                                <option value="email">email</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">通知人邮箱</label>

                                        <div class="col-sm-10">
                                            <input type="text" placeholder="请填写邮箱" class="form-control" v-model="type_value">
                                        </div>
                                    </div>

                                    <div class="form-group" style="display: none;">
                                        <label class="col-sm-2 control-label">Checker ID</label>

                                        <div class="col-sm-10">
                                            <input type="text" step="1" min="1" class="form-control" v-model="checker_id">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">监控信息</label>

                                        <div class="col-sm-10">
<!--                                            <input type="number" step="1" min="1" class="form-control">-->
                                            <select class="form-control"  v-model="check_field">
                                                <option value="">请选择</option>
                                                <?php
                                                 $check_fields = \Mirror\Service\AlerterService::getCheckFields()['data'];
                                                ?>

                                                <volist name="check_fields" id="check_field">
                                                    <option value="{$check_field['class']}">{$check_field['name']}</option>
                                                </volist>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">比较符</label>

                                        <div class="col-sm-10">
                                            <select class="form-control" v-model="check_operator">
                                                <option value="">请选择</option>
                                                <option value="GT">大于</option>
                                                <option value="LT">小于</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">监控阀值</label>

                                        <div class="col-sm-10">
                                            <input type="number" step="1" min="1" class="form-control" v-model="check_value">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">监控频率(分钟)</label>

                                        <div class="col-sm-10">
                                            <input type="number" step="1" min="1" class="form-control" v-model="minute">
                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label class="col-sm-2 control-label">使用状态</label>

                                        <div class="col-sm-10">
                                            <div class="radio" style="display: inline-block;">
                                                <label>
                                                    <input type="radio" name="enable" value="1" v-model="enable">
                                                    启用
                                                </label>
                                            </div>

                                            <div class="radio" style="display: inline-block;">
                                                <label>
                                                    <input type="radio" name="enable" value="0"  v-model="enable">
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
                    id: "{:I('get.alert_id', '')}",
                    type: "<?php echo !isset($data['type'])? 'email':$data['type']; ?>",
                    type_value: "<?php echo !isset($data['type_value'])? '':$data['type_value']; ?>",
                    checker_id: "{:I('get.checker_id', empty($data['checker_id'])? '':$data['checker_id'])}",
                    check_field: "<?php echo addslashes(!isset($data['check_field'])? '':$data['check_field']); ?>",
                    check_operator: "<?php echo !isset($data['check_operator'])? '':$data['check_operator']; ?>",
                    check_value: "<?php echo !isset($data['check_value'])? '':$data['check_value']; ?>",
                    minute:  "<?php echo !isset($data['minute'])? '5':$data['minute']; ?>",
                    enable: "<?php echo !isset($data['enable'])? '1':$data['enable']; ?>"
                },
                mounted: function(){
                    $('#app').show();
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
                            type: that.type,
                            type_value: that.type_value,
                            checker_id: that.checker_id,
                            check_field: that.check_field,
                            check_operator: that.check_operator,
                            check_value: that.check_value,
                            minute: that.minute,
                            enable: that.enable
                        };

                        var req_url = '';
                        if(that.id === ''){
                            req_url = "{:U('Mirror/Index/do_create_alert')}";
                        }else{
                            req_url = "{:U('Mirror/Index/do_edit_alert')}";
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