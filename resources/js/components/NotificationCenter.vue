<template>
  <div class="notification-center">
    <button
      @click="showNotifications = !showNotifications"
      class="relative p-2 text-gray-500 hover:text-gray-700"
    >
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
      </svg>
      <span
        v-if="unreadCount > 0"
        class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"
      >
        {{ unreadCount }}
      </span>
    </button>

    <div
      v-if="showNotifications"
      class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg overflow-hidden z-50"
    >
      <div class="p-4 border-b">
        <h3 class="text-lg font-semibold">Notifications</h3>
      </div>

      <div class="max-h-96 overflow-y-auto">
        <div
          v-for="notification in notifications"
          :key="notification.id"
          class="p-4 border-b hover:bg-gray-50"
          :class="{ 'bg-blue-50': !notification.read_at }"
        >
          <div class="flex items-start">
            <div class="flex-1">
              <p class="text-sm">{{ notification.data.message }}</p>
              <p class="text-xs text-gray-500 mt-1">
                {{ formatDate(notification.created_at) }}
              </p>
            </div>
            <button
              v-if="!notification.read_at"
              @click="markAsRead(notification)"
              class="ml-2 text-blue-600 hover:text-blue-800"
            >
              Mark as read
            </button>
          </div>
        </div>

        <div v-if="notifications.length === 0" class="p-4 text-center text-gray-500">
          No notifications
        </div>
      </div>

      <div class="p-4 border-t">
        <button
          v-if="notifications.length > 0"
          @click="markAllAsRead"
          class="text-sm text-blue-600 hover:text-blue-800"
        >
          Mark all as read
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'

export default {
  setup() {
    const notifications = ref([])
    const showNotifications = ref(false)

    const unreadCount = computed(() => {
      return notifications.value.filter(n => !n.read_at).length
    })

    const fetchNotifications = async () => {
      try {
        const response = await axios.get('/api/notifications')
        notifications.value = response.data
      } catch (error) {
        console.error('Error fetching notifications:', error)
      }
    }

    const markAsRead = async (notification) => {
      try {
        await axios.put(`/api/notifications/${notification.id}/mark-as-read`)
        notification.read_at = new Date().toISOString()
      } catch (error) {
        console.error('Error marking notification as read:', error)
      }
    }

    const markAllAsRead = async () => {
      try {
        await axios.put('/api/notifications/mark-all-as-read')
        notifications.value.forEach(notification => {
          notification.read_at = new Date().toISOString()
        })
      } catch (error) {
        console.error('Error marking all notifications as read:', error)
      }
    }

    const formatDate = (date) => {
      return new Date(date).toLocaleString()
    }

    onMounted(() => {
      fetchNotifications()
    })

    return {
      notifications,
      showNotifications,
      unreadCount,
      markAsRead,
      markAllAsRead,
      formatDate
    }
  }
}
</script> 