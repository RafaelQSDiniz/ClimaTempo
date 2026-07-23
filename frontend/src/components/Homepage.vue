<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import Searchform from "@/components/Searchform.vue";

const scroll = ref(0)

const handleScroll = () => {
  scroll.value = window.scrollY
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>

<template>
    <section class="sticky top-0 h-[70vh]">
      <div class="sticky top-0 h-screen overflow-hidden bg-gradient-to-b from-sky-400 to-sky-200">
          <div class="absolute inset-0 flex flex-col items-center justify-center font-montserrat  text-2xl text-gray-100 z-10">
            <span class="text-7xl font-extrabold">Clima Tempo</span>
            <span class="pt-1">Consulte o clima da sua cidade agora mesmo</span>
          </div>

          <div class="absolute top-12 left-12 w-40 min-h-[100px] w-[100px] rounded-full bg-yellow-100"
               :style="{
                   transform: `translateX(-${scroll * 0.08}px) `
              }"
          ></div>

          <div
              class="absolute left-10 top-2/5 w-[180px] min-h-[50px] rounded-full bg-gray-100 opacity-90"
              :style="{
                   transform: `translateX(-${scroll * 0.3}px) translateY(-50%)`
              }"
          ></div>

          <div
              class="absolute right-25 top-3/5 w-[160px] min-h-[40px] rounded-full bg-gray-100 opacity-95"
              :style="{
                     transform: `translateX(${scroll * 0.5}px) translateY(-50%)`
                }"
          ></div>

          <div
              class="absolute right-10 top-1/4 w-[180px] min-h-[50px] rounded-full bg-gray-100 opacity-80"
              :style="{
                     transform: `translateX(${scroll * 0.1}px) translateY(-50%)`
                }"
          ></div>
      </div>
    </section>
    <section class="relative z-20 -mt-[250px] min-h-screen">
      <div class="relative h-[250px] overflow-hidden">
        <div class="absolute left-0 bottom-0 w-[50%] z-10">
          <div class="h-[150px] bg-cyan-600 rounded-t-[150%]"></div>
          <div class="h-[60px] bg-gradient-to-b from-cyan-600 to-cyan-700"></div>
        </div>
        <div class="absolute right-0 bottom-0 w-[55%] z-20">
          <div class="h-[150px] bg-cyan-700 rounded-t-[150%]"></div>
          <div class="h-[60px] bg-cyan-700"></div>
        </div>
      </div>
      <div class="bg-cyan-700 min-h-[100vh] w-full">
        <searchform></searchform>
      </div>
    </section>
</template>

<style scoped>

</style>