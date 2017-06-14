<extend name="../../Admin/View/Common/base_layout"/>

<block name="content">
    <div id="app" style="padding: 8px;">
<!--        <div class="row">-->
<!--            <div class="col-sm-6">-->
<!--                <h4>搜索</h4>-->
<!--            </div>-->
<!--            <div class="col-sm-6">-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--        <hr>-->
        <div class="search_type cc mb10" style="display: none;">
            消息源：<input type="text" v-model="where.target" name="" class="input">
            发送者：<input type="text" v-model="where.sender" name="" class="input">
            接收者：<input type="text" v-model="where.receiver" name="" class="input">
            是否处理：<select v-model="where.process_status"  style="background: white;height: 28px;">
                <option value="">处理状态</option>
                <option value="0">未处理</option>
                <option value="1">已处理</option>
            </select>
            是否阅读：<select v-model="where.read_status" style="background: white;height: 28px;">
                <option value="">处理状态</option>
                <option value="0">未读</option>
                <option value="1">已读</option>
            </select>
            <button @click="getList" class="btn btn-primary" style="margin-left: 8px;">搜索</button>
        </div>
        <hr>
        <form action="" method="post">
            <div class="table_list">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr style="background: ghostwhite;">
                        <td width="50" align="left">ID</td>
                        <td width="100" align="left">网址</td>
                        <td width="100" align="left">开始时间</td>
                        <td width="100" align="left">结束时间</td>
                        <td width="80" align="left">状态码</td>
                        <td width="80" align="left">耗时</td>
                        <td width="80" align="left">执行结果</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in items">
                        <td >
                            {{ item.id }}
                        </td>
                        <td>
                            {{ item.url }}
                        </td>
                        <td >
                            {{ item.start_time | getFormatTimeWithMillionScecond }}

                        </td>
                        <td >
                            {{ item.end_time | getFormatTimeWithMillionScecond }}
                        </td>
                        <td >
                            {{ item.status_code  }}
                        </td>
                        <td >
                            {{ item.end_time - item.start_time  }} ms
                        </td>
                        <td >
                            <template v-if="item.result == 0">
                                <span style="color: green;">正常</span>
                            </template>
                            <template v-if="item.result != 0">
                                <span style="color: red;">异常</span>
                            </template>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div v-if="page_count > 1" style="text-align: center">
                    <ul class="pagination pagination-sm no-margin">
                        <li>
                            <a @click="page > 1 ? (page--) : '' ;getList()" href="javascript:;">上一页</a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ page }} / {{ page_count }}</a>
                        </li>
                        <li><a @click="page<page_count ? page++ : '' ;getList()" href="javascript:;">下一页</a></li>
                    </ul>
                </div>
            </div>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            new Vue({
                el: '#app',
                data: {
                    items: [],
                    page: 1,
                    limit: 20,
                    page_count: 0,
                    total: 0,
                    where: {
                        checker_id: "{:I('get.checker_id')}"
                    }
                },
                filters: {
                    getFormatTimeWithMillionScecond: function (value) {
                        if(value == '' || value == 0){
                            return '/';
                        }
                        var time = new Date(parseInt(value));
                        var y = time.getFullYear();
                        var m = time.getMonth() + 1;
                        var d = time.getDate();
                        var h = time.getHours();
                        var i = time.getMinutes();
                        var ms = time.getMilliseconds();
                        var res = y + '-' + (m < 10 ? '0' + m : m) + '-' + (d < 10 ? '0' + d : d)
                        res += '  ' + (h < 10 ? '0' + h : h) + ':' + (i < 10 ? '0' + i : i);
                        return res;
                    },
                },
                methods: {
                    getList: function () {
                        var that = this;
                        var where = {
                            page: this.page,
                            limit: this.limit,
                            where: this.where
                        };
                        $.ajax({
                            url: "{:U('Mirror/Index/getLogs')}",
                            data: where,
                            dataType: 'json',
                            type: 'get',
                            success: function (res) {
                                var data = res.data;
                                that.items = data.items;
                                that.page = data.page;
                                that.limit = data.limit;
                                that.page_count = data.page_count;
                            }
                        })
                    },
                    //处理消息
                    handleMessage: function (message_id){
                        $.ajax({
                            url: "{:U('Message/Message/handleMessage')}",
                            data: {
                                message_id: message_id
                            },
                            dataType: 'json',
                            type: 'post',
                            success: function (res) {
                                if(res.status){
                                    layer.msg('操作完成！');
                                }else{
                                    layer.msg(res.msg);
                                }
                            }
                        });
                    }
                },
                mounted: function () {
                    this.getList();
                }
            })
        })
    </script>
</block>
