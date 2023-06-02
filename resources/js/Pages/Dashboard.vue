<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    
});
</script>

<template>
    <Head title="Simple Memo" />

    <div class="bc8 he1">
        <div class="wi12 dis mcenter">
            <div class="original-text-shadow mt10">Simple Memo</div>
            <div class="mr dis f1-5">
                <div class="mr20"><button onclick="location.href='/memo/logout'" class="btn btn-primary mt20">ログアウト</button></div>        
                <div><button onclick="location.href='/memo/register'"  class="btn btn-primary mt20">新規登録</button></div>
            </div>
        </div>
        <div class="wi12 mcenter mt10 tr">\\ こんにちは //</div>
    </div>

    <div class="bc9 he7">
        <div class="wi13 mcenter">
            <div class="dis ccenter mb30">
                <div class="wi4 linkbox he3 mt20">
                    <a href="/memo"></a>
                    <p class="f3 mt40 mb10 ml20">Simple</p>
                    <p class="f3 tr mr20">Memo</p>
                    <p class="f2 tcenter mt20"><i class="fa-brands fa-golang mr10"></i><i class="fa-solid fa-circle-right"></i></p>
                   
                </div>               
            </div>        
        </div>
    </div>
</template>

<style>
.original-text-shadow {
  display: flex;
  align-items: center;
  justify-content: center;
  line-height: 1;
  color: #000000;
  font-size: 50px;
  text-shadow: 0px 20px 8px rgba(0, 0, 0, 0.4);
  font-weight: bold;
}
</style>