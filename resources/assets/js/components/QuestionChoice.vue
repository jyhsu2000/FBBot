<template>
    <div class="card-block row">
        <div class="col-sm-1">
            <i class="fa fa-arrows-v fa-2x btn btn-secondary handle" aria-hidden="true"></i>
        </div>
        <div class="col-sm-1">
            <button class="btn btn-secondary" @click.prevent="toggleCorrect(choice.id)">
                <i class="fa fa-check fa-fw fa-2x text-success" aria-hidden="true"
                   v-if="choice.is_correct"></i>
                <i class="fa fa-times fa-fw fa-2x text-danger" aria-hidden="true" v-else></i>
            </button>
        </div>
        <div class="col-sm-9">
            <template v-if="!editMode">
                {{ choice.content }}
            </template>
            <form class="form-inline" @submit.prevent="submit" v-else>
                <div class="row">
                    <div class="col-sm-8">
                        <input type="text" class="form-control" required v-model="choiceInput"
                               :value="choice.content" style="width: 100%"/>
                    </div>
                    <div class="col-sm-4">
                        <input type="submit" value="更新" class="btn btn-primary" :disabled="choice.content.length <= 0"/>
                        <button class="btn btn-secondary" @click.prevent="editMode = false">取消</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-1">
            <button class="btn btn-primary" :disabled="editMode" @click.prevent="editMode = true">
                <i class="fa fa-pencil" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                editMode: false,
                choiceInput: '',
            }
        },
        props: [
            'choice',
            'choice_api',
        ],
        methods: {
            toggleCorrect: function (choiceId) {
                //發送請求
                this.$http.post(this.choice_api + '/toggleCorrect/' + choiceId).then(function (response) {
                    var json = response.body;
                    //即時顯示
                    this.choice.is_correct = json.is_correct;
                    //顯示通知
                    alertify.notify('已更新', 'success', 5);
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            },
            submit: function () {
                var input = this.choiceInput;
                //去除頭尾空白
                input = $.trim(input);
                //檢查輸入
                if (input.length == 0) {
                    return;
                }
                //發送請求
                this.$http.patch(this.choice_api + '/' + this.choice.id, {
                    content: input
                }).then(function (response) {
                    var json = response.body;
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
                    //即時顯示
                    this.choice.content = json.content;
                    //顯示通知
                    alertify.notify('已更新', 'success', 5);
                    //關閉輸入模式
                    this.editMode = false;
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
