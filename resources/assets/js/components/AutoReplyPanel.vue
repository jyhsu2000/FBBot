<template>
    <div class="card">
        <div class="card-header">
            新增
        </div>
        <div class="card-block">
            <form class="form-inline row" @submit.prevent="submit">
                <div class="col-sm-10">
                    <input type="text" name="autoReplyInput" class="form-control form-control-lg"
                           placeholder="請輸入欲新增之名稱" required style="width: 100%"
                           v-model="autoReplyInput">
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary btn-lg"
                            :disabled="autoReplyInput.length <= 0">
                        新增
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div v-sortable="{ onUpdate: onUpdate, handle: '.handle' }">
        <template v-for="autoReply in autoReplies">
            <auto-reply :reply="autoReply"></auto-reply>
        </template>
    </div>
</template>

<script>
    export default {
        ready() {
            this.$nextTick(function () {
                this.fetch();
            });
        },
        data: function () {
            return {
                autoReplyInput: '',
                autoReplies: []
            }
        },
        props: ['api'],
        methods: {
            fetch: function () {
                this.$http.get(this.api + '/data').then(function (response) {
                    var json = response.json();
                    var autoReplies = [];
                    $.each(json, function (key, value) {
                        autoReplies.push(value);
                    });
                    this.autoReplies = autoReplies;
                });
            },
            submit: function () {
                var input = $.trim(this.autoReplyInput);
                //檢查輸入
                if (input.length == 0) {
                    return;
                }
                //發送請求
                this.$http.post(this.api, {
                    name: input
                }).then(function (response) {
                    var json = response.json();
                    if (json.success != true) {
                        window.errorMessage = '';
                        $.each(json.errors, function (field, item) {
                            $.each(item, function (key, value) {
                                window.errorMessage += '<br/>' + field + ':' + value;
                            });
                        });
                        alertify.notify('新增失敗' + window.errorMessage, 'warning', 5);
                        return;
                    }
                    //即時顯示
                    this.autoReplies.push(json.autoReply);
                    //顯示通知
                    alertify.notify('已新增', 'success', 5);
                    //清空輸入框
                    this.autoReplyInput = '';
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            },
            destroy: function (autoReply) {
                if (!confirm('確定要刪除嗎？')) {
                    return;
                }
                //發送請求
                this.$http.delete(this.api + '/' + autoReply.id).then(function (response) {
                    var json = response.json();
                    if (json.success != true) {
                        alertify.notify('刪除失敗', 'warning', 5);
                        return;
                    }
                    //移除該項
                    this.autoReplies.splice($.inArray(autoReply, this.autoReplies), 1);
                    //顯示通知
                    alertify.notify('已刪除', 'success', 5);
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            },
            onUpdate: function (event) {
                this.autoReplies.splice(event.newIndex, 0, this.autoReplies.splice(event.oldIndex, 1)[0]);
                var idList = [];
                $.each(this.autoReplies, function (key, autoReply) {
                    idList.push(autoReply.id);
                });
                //發送請求
                this.$http.post(this.api + '/sort', {
                    idList: idList
                }).then(function (response) {
                    //重新獲取資料
                    this.fetch();
                    //顯示通知
                    alertify.notify('排序已更新', 'success', 5);
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            },
            updateName: function (autoReply, newName) {
                //發送請求
                this.$http.patch(this.api + '/' + autoReply.id, {
                    name: newName
                }).then(function (response) {
                    var json = response.json();
                    if (json.success != true) {
                        window.errorMessage = '';
                        $.each(json.errors, function (field, item) {
                            $.each(item, function (key, value) {
                                window.errorMessage += '<br/>' + field + ':' + value;
                            });
                        });
                        alertify.notify('更新失敗' + window.errorMessage, 'warning', 5);
                        return;
                    }
                    //顯示通知
                    alertify.notify('已更新', 'success', 5);
                    //更新介面顯示名稱
                    autoReply.name = newName;
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            }
        }
    }
</script>
