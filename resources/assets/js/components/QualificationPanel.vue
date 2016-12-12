<style>
    #nidInput, #nidSubmitButton {
        font-size: 50px
    }
</style>
<template>
    <div class="card">
        <div class="card-header">
            輸入NID
        </div>
        <div class="card-block">
            <form @submit.prevent="">
                <div class="input-group">
                    <input id="nidInput" class="form-control" type="text" required
                           placeholder="掃描學生證條碼 或 輸入NID">
                    <span class="input-group-btn">
                        <button id="nidSubmitButton" class="btn btn-secondary" type="submit">
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
        data: function(){
        },
        props: [
            'api'
        ]
    }
</script>
