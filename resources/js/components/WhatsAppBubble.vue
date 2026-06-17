<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  nomorWA: {
    type: String,
    default: '6285311696756'
  },
  pesanDefault: {
    type: String,
    default: 'Halo, saya ingin bertanya mengenai produk Toko Beras Jagat Nusantara.'
  }
})

const showToast = ref(false)

const handleWhatsAppClick = () => {
  showToast.value = true
  setTimeout(() => {
    showToast.value = false
  }, 2000)
}

const whatsappUrl = computed(() => {
  const nomor = props.nomorWA.replace(/\D/g, '') // Remove non-digits
  const message = encodeURIComponent(props.pesanDefault)
  return `https://wa.me/${nomor}?text=${message}`
})
</script>

<template>
  <!-- Floating WhatsApp Bubble -->
  <a 
    :href="whatsappUrl" 
    target="_blank" 
    rel="noopener noreferrer"
    class="wa-bubble" 
    title="Chat via WhatsApp"
    @click="handleWhatsAppClick"
  >
    <i class="bi bi-whatsapp"></i>
  </a>

  <!-- WhatsApp Notification Toast -->
  <transition name="slideUp">
    <div v-if="showToast" class="wa-toast">
      <div class="wa-toast-content">
        <i class="bi bi-check-circle-fill" style="color: #25D366;"></i>
        <span>Membuka WhatsApp...</span>
      </div>
    </div>
  </transition>
</template>

<style scoped>
.slideUp-enter-active,
.slideUp-leave-active {
  transition: all 0.3s ease;
}

.slideUp-enter-from {
  opacity: 0;
  transform: translateY(10px);
}

.slideUp-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>
