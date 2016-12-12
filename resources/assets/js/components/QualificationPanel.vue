<style>
    #nidInput, #nidSubmitButton {
        font-size: 50px
    }
</style>
<template>
    <div class="card">
        <div class="card-header">
            輸入NID
            <label class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" v-model="autoFocus">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description">Auto Focus</span>
            </label>
        </div>
        <div class="card-block">
            <form @submit.prevent="">
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
                focused: true
            }
        },
        props: [
            'api'
        ],
        watch: {
            autoFocus: function (val, oldVal) {
                if(val){
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
            }
        }
    }
</script>
