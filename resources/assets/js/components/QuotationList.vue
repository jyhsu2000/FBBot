<template>
    <div class="card">
        <div class="card-header">
            新增
        </div>
        <div class="card-block">
            <form class="form-inline row" @submit.prevent="submit">
                <div class="col-sm-10">
                    <input type="text" name="quotation" class="form-control form-control-lg"
                           placeholder="請輸入欲新增之內容" required style="width: 100%"
                           v-model="quotationInput">
                </div>
                <div class="col-sm-2">
                    <button type="submit" class="btn btn-primary btn-lg"
                            :disabled="quotationInput.length <= 0">
                        新增
                    </button>
                </div>
            </form>
        </div>
    </div>
    <template v-for="quotation in quotations">
        <quotation :quotation="quotation"></quotation>
    </template>
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
                quotationInput: '',
                quotations: []
            }
        },
        props: ['api'],
        methods: {
            fetch: function () {
                this.$http.get(this.api + '/data').then(function (response) {
                    var json = response.json();
                    var quotations = [];
                    $.each(json, function (key, value) {
                        quotations.push(value);
                    });
                    this.quotations = quotations;
                });
            },
            submit: function () {
                var input = this.quotationInput;
                //去除頭尾空白
                input = $.trim(input);
                //檢查輸入
                if (input.length == 0) {
                    return;
                }
                console.log('submit:' + input);
                //發送請求
                this.$http.post(this.api, {
                    content: input
                }).then(function (response) {
                    var json = response.json();
                    console.log(json);
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
                    this.quotations.push(json.quotation);
                    //顯示通知
                    alertify.notify('已新增', 'success', 5);
                    //清空輸入框
                    this.quotationInput = '';
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            },
            destroy: function (quotation) {
                console.log('destroy: ' + quotation.id);
                //發送請求
                this.$http.delete(this.api + '/' + quotation.id).then(function (response) {
                    var json = response.json();
                    console.log(json);
                    if (json.success != true) {
                        alertify.notify('刪除失敗', 'warning', 5);
                        return;
                    }
                    //移除該項
                    this.quotations.splice($.inArray(quotation, this.quotations), 1);
                    //顯示通知
                    alertify.notify('已刪除', 'success', 5);
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
