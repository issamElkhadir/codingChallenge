import axios from "axios";
import {ref} from "vue";

export function useApiSave(path) {
  
  const error = ref(null)

  const saving = ref(false)

  const save = async (payload, { onSuccess = () => {}, onError = () => {} } = {}) => {
    saving.value = true

    return await axios
      .post(`${path}` , payload)
      .then((response) => {
        onSuccess && onSuccess(response.data)

        return response.data
      })
      .catch((e) => {
        error.value = e.response.data.message
        
        onError && onError(e.response.data)
      })
      .finally(() => {
        saving.value = false
      })
  }

  return {
    saving,
    error,
    save
  }
}
