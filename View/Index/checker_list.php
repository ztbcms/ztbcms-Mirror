<extend name="../../Admin/View/Common/base_layout"/>

<block name="content">
    <div id="app" style="padding: 8px;">
        <div class="row">
            <div class="col-sm-6">
                <h4>Checker 列表</h4>
            </div>
            <div class="col-sm-6">
                <a href="{:U('Mirror/Index/create_checker')}" class="btn btn-success  pull-right" style="margin-left: 8px;">新增Checker</a>

            </div>
        </div>
        <hr>
        <div class="search_type cc mb10">
            网址：<input type="text" v-model="where.url" name="" class="input">
            启用状态：<select v-model="where.enable" style="background: white;height: 28px;">
                <option value="">全部</option>
                <option value="1">启用</option>
                <option value="0">禁用</option>
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
                        <td width="100" align="left">频率</td>
                        <td width="100" align="left">下次执行时间</td>
                        <td width="80" align="left">是否启用</td>
                        <td width="120" align="left">操作</td>
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
                            {{ item.minute }} 分钟/次

                        </td>
                        <td >
                            {{ item.next_time | getFormatTime }}
                        </td>
                        <td >
                            <template v-if="item.enable == 1">
                                <span style="color: green;">是</span>
                            </template>
                            <template v-if="item.enable == 0">
                                <span style="color: red;">否</span>
                            </template>
                        </td>
                        <td >
                            <a :href="'/Mirror/Index/logs?checker_id=' + item.id" type="button" class="btn btn-primary">日志</a>
                            <a :href="'/Mirror/Index/alert_list?checker_id=' + item.id " class="btn btn-primary ">Alert 列表</a>
                            <a :href="'/Mirror/Index/create_alert?checker_id=' + item.id " class="btn btn-success ">新增 Alert</a>
                            <button type="button" class="btn btn-danger" @click="doDelete(item.id)">删除</button>
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
                        url: '',
                        enable: ''
                    }
                },
                filters: {
                    getFormatTime: function (value) {
                        if(value == '' || value == 0){
                            return '/';
                        }
                        var time = new Date(parseInt(value * 1000));
                        var y = time.getFullYear();
                        var m = time.getMonth() + 1;
                        var d = time.getDate();
                        var h = time.getHours();
                        var i = time.getMinutes();
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
                            url: "{:U('Mirror/Index/getCheckerList')}",
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
                    //删除
                    doDelete: function (id){
                        if(confirm('确认删除？')){
                            $.ajax({
                                url: "{:U('Mirror/Index/do_delete_checker')}",
                                data: {
                                    id: id
                                },
                                dataType: 'json',
                                type: 'post',
                                success: function (res) {
                                    if(res.status){
                                        layer.msg('操作完成！');
                                        setTimeout(function(){
                                            window.location.reload();
                                        }, 700)
                                    }else{
                                        layer.msg(res.msg);
                                    }
                                }
                            });
                        }

                    }
                },
                mounted: function () {
                    this.getList();
                }
            })
        })
    </script>
</block>
