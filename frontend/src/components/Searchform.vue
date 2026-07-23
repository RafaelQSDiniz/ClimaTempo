<script setup>
import { ref, computed } from 'vue'
import locations from '@/assets/brazil-locations.json'
import api from '@/services/api'

const states = Object.keys(locations).sort()

const selectedState = ref('')
const selectedCity = ref('')
const weather = ref(null)
const error = ref('')
const loading = ref(false)

const cities = computed(() => {
  return selectedState.value ? locations[selectedState.value] : []
})

function onStateChange() {
  selectedCity.value = ''
}

async function handleSubmit() {
  loading.value = true
  error.value = ''
  weather.value = null

  try {
    const response = await api.get('/weather', {
      params: { city: selectedCity.value, state: selectedState.value },
    })
    weather.value = response.data
  } catch (err) {
    error.value = 'Não foi possível buscar o clima. Tente novamente.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="w-full flex bg-cyan-700 justify-center min-h-[80vh]">
    <div class="pt-[180px]">
      <div class="flex justify-between min-w-[800px]">
        <form @submit.prevent="handleSubmit" class="w-[350px] bg-white rounded-xl shadow-md p-6 flex flex-col gap-4">
          <div class="flex flex-col gap-1">
            <label for="state" class="text-sm font-medium text-gray-700">Estado</label>
            <select
                id="state"
                v-model="selectedState"
                @change="onStateChange"
                required
                class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              <option value="" disabled>Selecione o estado</option>
              <option v-for="uf in states" :key="uf" :value="uf">{{ uf }}</option>
            </select>
          </div>

          <div class="flex flex-col gap-1">
            <label for="city" class="text-sm font-medium text-gray-700">Cidade</label>
            <select
                id="city"
                v-model="selectedCity"
                :disabled="!selectedState"
                required
                class="w-full rounded-md border border-gray-300 px-3 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:opacity-50"
            >
              <option value="" disabled>Selecione a cidade</option>
              <option v-for="city in cities" :key="city" :value="city">{{ city }}</option>
            </select>
          </div>

          <button
              type="submit"
              :disabled="loading"
              class="mt-2 w-full rounded-md bg-cyan-500 py-2 font-medium text-white transition-colors hover:bg-cyan-800 disabled:cursor-not-allowed disabled:opacity-60"
          >
            {{ loading ? 'Buscando...' : 'Buscar clima' }}
          </button>
        </form>
        <div v-if="weather" class="min-w-[350px]">
          <div class="w-full rounded-xl bg-white p-6 shadow-md">
            <h3 class="text-lg font-semibold text-gray-800">
              {{ weather.location.name }} - {{ weather.location.state }}
            </h3>
            <p class="mt-2 text-4xl font-bold text-gray-900">{{ weather.weather.main.temp.toFixed(1) }}°C</p>
            <p class="text-sm text-gray-500 capitalize pt-3">{{ weather.weather.weather[0].description }}</p>
            <div class="pt-3 grid grid-cols-3 gap-3 text-sm text-gray-600">
              <div>
                <dt class="text-xs uppercase text-gray-400">Sensação</dt>
                <dd class="font-medium text-gray-800">{{ weather.weather.main.feels_like.toFixed(1) }}°C</dd>
              </div>
              <div>
                <dt class="text-xs uppercase text-gray-400">Umidade</dt>
                <dd class="font-medium text-gray-800">{{ weather.weather.main.humidity }}%</dd>
              </div>
              <div>
                <dt class="text-xs uppercase text-gray-400">Vento</dt>
                <dd class="font-medium text-gray-800">{{ weather.weather.wind.speed }} m/s</dd>
              </div>
            </div>
          </div>
          <div class="flex items-center justify-end pt-3 ">
            <div class="flex pr-2">
              <p class="font-montserrat text-white pr-1">
                Fonte: <a href="https://openweathermap.org" class="font-semibold text-white" target="_blank">OpenWeather</a>
              </p>
              <a href="https://openweathermap.org" target="_blank">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 -960 960 960" fill="white">
                  <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h560v-280h80v280q0 33-23.5 56.5T760-120H200Zm188-212-56-56 372-372H560v-80h280v280h-80v-144L388-332Z"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
      <p v-if="error" class="mt-4 text-sm text-red-600">{{ error }}</p>
    </div>
  </div>
</template>
