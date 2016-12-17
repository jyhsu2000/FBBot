<template>
    <div class="card">
        <div class="card-header">
            新增
        </div>
        <div class="card-block">
            <form class="form-inline row" @submit.prevent="submit">
                <div class="col-sm-10">
                    <input type="text" name="keyword" class="form-control form-control-lg"
                           placeholder="關鍵字" required style="width: 100%"
                           v-model="keywordInput">
                    <textarea name="reply" class="form-control" placeholder="自動回應" required
                              v-model="replyInput" style="width: 100%" rows="5"></textarea>
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary btn-lg"
                            :disabled="keywordInput.length <= 0 || replyInput.length <= 0">
                        新增
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                keywordInput: '',
                replyInput: ''
            }
        },
        props: ['api'],
        methods: {
            submit: function () {
                var keyword = $.trim(this.keywordInput);
                var reply = $.trim(this.replyInput);
                //檢查輸入
                if (keyword.length == 0 || reply.length == 0) {
                    return;
                }
                //發送請求
                this.$http.post(this.api, {
                    keyword: keyword,
                    reply: reply
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
                    //清空輸入框
                    this.keywordInput = '';
                    this.replyInput = '';
                    //更新表格
                    window.LaravelDataTables.dataTableBuilder.ajax.reload();
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
