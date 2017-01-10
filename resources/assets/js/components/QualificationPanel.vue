<style>
    #nidInput, #nidSubmitButton {
        font-size: 50px
    }
</style>
<template>
    <div>
        <div class="card">
            <div class="card-header">
                輸入NID
                <label class="custom-control custom-checkbox" style="margin: 0">
                    <input type="checkbox" class="custom-control-input" v-model="autoFocus">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Auto Focus</span>
                </label>
            </div>
            <div class="card-block">
                <form @submit.prevent="findPlayer">
                    <div class="input-group">
                        <input id="nidInput" class="form-control" type="text" required v-model="nidInput"
                               :placeholder="focused ? '掃描學生證條碼 或 輸入NID' : '請點擊此處'"
                               v-focus="focused" @focus="focused = true" @blur="onLostFocus" autofocus>
                        <span class="input-group-btn">
                        <button id="nidSubmitButton" class="btn btn-secondary" type="submit"
                                :disabled="nidInput.length <= 0">
                            <i class="fa fa-search" aria-hidden="true"></i>
                        </button>
                    </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                玩家
            </div>
            <div class="card-block text-sm-center" v-if="nid">
                <template v-if="!player">
                    <span class="text-danger" style="font-size: 50px">找不到玩家：{{ nid }}</span><br/>
                    <button class="btn btn-danger" style="font-size: 30px" @click="forceGrant">
                        <i class="fa fa-check-square-o" aria-hidden="true"></i> 強制標記為已抽獎
                    </button>
                </template>
                <template v-else>
                    <span class="text-primary" style="font-size: 50px">玩家：{{ nid }}</span><br/>
                    <div style="font-size: 30px">
                        <template v-if="player.qualification">
                            <template v-if="player.qualification.get_at">
                                <span class="text-primary">已抽獎 （{{ player.qualification.get_at }}）</span>
                            </template>
                            <template v-else>
                                <span class="text-success">已取得抽獎資格</span><br/>
                                <button class="btn btn-success" style="font-size: 50px" @click="grant">
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i> 標記為已抽獎
                                </button>
                            </template>
                        </template>
                        <template v-else>
                            <span class="text-danger">未取得抽獎資格</span><br/>
                            <button class="btn btn-danger" style="font-size: 30px" @click="forceGrant">
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 強制標記為已抽獎
                            </button>
                        </template>
                    </div>
                </template>
            </div>
            <div class="card-block text-sm-center" style="font-size: 50px" v-else>
                ﾚ(ﾟ∀ﾟ;)ﾍ　ﾍ( ﾟ∀ﾟ;)ﾉ
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        directives: {
            focus: Focus
        },
        data: function () {
            return {
                nidInput: '',
                autoFocus: true,
                focused: true,
                nid: '',
                player: {}
            }
        },
        props: [
            'api'
        ],
        watch: {
            autoFocus: function (val, oldVal) {
                if (val) {
                    $('#nidInput').focus()
                }
            }
        },
        methods: {
            onLostFocus: function () {
                this.focused = false;
                if (this.autoFocus) {
                    $('#nidInput').focus()
                }
            },
            findPlayer: function () {
                var input = $.trim(this.nidInput);
                this.nidInput = '';
                //檢查輸入
                if (input.length == 0) {
                    return;
                }
                //發送請求
                this.$http.post(this.api + '/find', {
                    nid: input
                }).then(function (response) {
                    var json = response.body;
                    this.nid = json.nid;
                    this.player = json.player;
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            },
            grant: function () {
                var nid = this.nid;
                //檢查輸入
                if (nid.length == 0) {
                    return;
                }
                //發送請求
                this.$http.post(this.api + '/grant', {
                    nid: nid
                }).then(function (response) {
                    var json = response.body;
                    if (json.success != true) {
                        alertify.notify('無法標記為已抽獎<br/>' + json.errorMessage, 'warning', 5);
                        return;
                    }
                    alertify.notify('已標記為已抽獎', 'success', 5);
                    this.player = json.player;
                }, function (response) {
                    console.log('Error: ');
                    console.log(response);
                    //顯示通知
                    alertify.notify('發生錯誤', 'warning', 5);
                });
            },
            forceGrant: function () {
                var nid = this.nid;
                //檢查輸入
                if (nid.length == 0) {
                    return;
                }
                //再次確認
                if (!confirm('確定要為 ' + nid + ' 強制抽獎嗎？')) {
                    return;
                }
                //發送請求
                this.$http.post(this.api + '/forceGrant', {
                    nid: nid
                }).then(function (response) {
                    var json = response.body;
                    if (json.success != true) {
                        alertify.notify('無法標記為已抽獎<br/>' + json.errorMessage, 'warning', 5);
                        return;
                    }
                    alertify.notify('已標記為已抽獎', 'success', 5);
                    this.player = json.player;
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
