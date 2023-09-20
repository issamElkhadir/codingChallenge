import axios from "axios";
import {ref} from "vue";

export function useApiGetResource(resource) {
  
  const error = ref(null)

  const loading = ref(false)

  const load = async (params, { onSuccess = () => {}, onError = () => {} } = {}) => {
    loading.value = true

    return await axios
      .get(`${resource}` , { params: params })
      .then((response) => {
        onSuccess && onSuccess(response.data)

        return response.data
      })
      .catch((e) => {
        error.value = e.response.data.message
        
        onError && onError(e.response.data)
      })
      .finally(() => {
        loading.value = false
      })
  }

  return {
    loading,
    error,
    load
  }
}
