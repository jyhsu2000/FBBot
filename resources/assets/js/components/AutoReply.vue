<template>
    <div class="list-group-item row">
        <div class="col-sm-1">
            <i class="fa fa-arrows-v fa-2x btn btn-secondary handle" aria-hidden="true"></i>
        </div>
        <div class="col-sm-1" style="white-space: nowrap">
            <span class="tag tag-default">#{{ reply.id }}</span>
        </div>
        <div class="col-sm-9">
            <i class="fa fa-pencil btn btn-primary" aria-hidden="true" @click="editName"></i>
            {{ reply.name }}
            <div class="row">
                <div class="col-sm-6">
                    關鍵字 <a href="javascript:void(0)" class="text-success" @click="addKeyword">[+新增]</a>
                    <ul>
                        <li v-for="keyword in reply.keywords">
                            <a href="javascript:void(0)" class="text-danger" @click="removeKeyword(keyword)">[X刪除]</a>
                            {{ keyword.keyword }}
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    回應內容 <a href="javascript:void(0)" class="text-success" @click="showMessageInput = true">[+新增]</a>
                    <form v-show="showMessageInput" @submit.prevent="submitMessage">
                        <textarea name="messageInput" id="messageInput" cols="30" rows="10" class="form-control"
                                  v-model="messageInput"></textarea>
                        <button type="submit" class="btn btn-primary">確認</button>
                        <button @click.prevent="showMessageInput = false" class="btn btn-secondary">取消</button>
                    </form>
                    <ul>
                        <li v-for="auto_reply_message in reply.auto_reply_messages">
                            <a href="javascript:void(0)" class="text-danger" @click="removeMessage(auto_reply_message)">[X刪除]</a>
                            <pre>{{ auto_reply_message.content }}</pre>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-1">
            <button class="btn btn-danger float-sm-right" @click="$parent.destroy(reply)">
                <i class="fa fa-trash-o" aria-hidden="true"></i> 刪除
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                showMessageInput: false,
                messageInput: ''
            }
        },
        props: [
            'api',
            'reply'
        ],
        methods: {
            editName: function () {
                var oldName = this.reply.name;
                var newName = $.trim(prompt("請輸入新名稱", oldName));
                if (newName == oldName || newName == null || newName.length == 0) {
                    return;
                }
                this.$parent.updateName(this.reply, newName);
            },
            addKeyword: function () {
                var keywordInput = $.trim(prompt("請輸入關鍵字"));
                if (keywordInput == null || keywordInput.length == 0) {
                    return;
                }
                //發送請求
                this.$http.post(this.api + '/storeKeyword', {
                    auto_reply_id: this.reply.id,
                    keyword: keywordInput
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
                    //顯示通知
                    alertify.notify('已新增', 'success', 5);
                    //更新清單
                    this.reply.keywords.push(json.keyword);
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            },
            removeKeyword: function (keyword) {
                if (!confirm("確定要刪除嗎？")) {
                    return
                }
                //發送請求
                this.$http.delete(this.api + '/destroyKeyword/' + keyword.id).then(function (response) {
                    var json = response.json();
                    if (json.success != true) {
                        window.errorMessage = '';
                        $.each(json.errors, function (field, item) {
                            $.each(item, function (key, value) {
                                window.errorMessage += '<br/>' + field + ':' + value;
                            });
                        });
                        alertify.notify('刪除失敗' + window.errorMessage, 'warning', 5);
                        return;
                    }
                    //顯示通知
                    alertify.notify('已刪除', 'success', 5);
                    //更新清單
                    this.reply.keywords.splice($.inArray(keyword, this.reply.keywords), 1);
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            },
            submitMessage: function () {
                var messageInput = $.trim(this.messageInput);
                if (messageInput == null || messageInput.length == 0) {
                    return;
                }
                //發送請求
                this.$http.post(this.api + '/storeMessage', {
                    auto_reply_id: this.reply.id,
                    content: messageInput
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
                    //顯示通知
                    alertify.notify('已新增', 'success', 5);
                    //更新清單
                    this.reply.auto_reply_messages.push(json.autoReplyMessage);
                    //清除輸入
                    this.messageInput = '';
                    this.showMessageInput = false;
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            },
            removeMessage: function (auto_reply_message) {
                if (!confirm("確定要刪除嗎？")) {
                    return
                }
                //發送請求
                this.$http.delete(this.api + '/destroyMessage/' + auto_reply_message.id).then(function (response) {
                    var json = response.json();
                    if (json.success != true) {
                        window.errorMessage = '';
                        $.each(json.errors, function (field, item) {
                            $.each(item, function (key, value) {
                                window.errorMessage += '<br/>' + field + ':' + value;
                            });
                        });
                        alertify.notify('刪除失敗' + window.errorMessage, 'warning', 5);
                        return;
                    }
                    //顯示通知
                    alertify.notify('已刪除', 'success', 5);
                    //更新清單
                    this.reply.auto_reply_messages.splice($.inArray(auto_reply_message, this.reply.auto_reply_messages), 1);
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
