import Toasted from 'vue-toasted';

export default function (Vue) {

  Vue.use(Toasted, {
    iconPack : 'fontawesome'
  });

  // Options to the toast notification
  let optionsSuccess = {
    type: 'success',
    icon: 'check_circle',
    action: [
      {
        text: 'Zatvori',
        onClick: (e, toastObject) => {
          toastObject.goAway(0);
        }
      }
    ],
    duration: 5000
  };

  // Options to the toast notification
  let optionsError = {
    type: 'error',
    icon: 'error_outline',
    action: [
      {
        text: 'Zatvori',
        onClick: (e, toastObject) => {
          toastObject.goAway(0);
        }
      }
    ],
    duration: 5000
  };

  // Register the toast with the custom message
  Vue.toasted.register('toastSuccess', (payload) => {

      // if there is no message passed show default message
      if (!payload.message) {
        return 'Uspešna akcija!'
      }

      // if there is a message show it with the message
      return payload.message
    },
    optionsSuccess
  );

  // Register the toast with the custom message
  Vue.toasted.register('toastError', (payload) => {

      // if there is no message passed show default message
      if (! payload.message) {
        return 'Greška!'
      }

      // if there is a message show it with the message
      return payload.message
    },
    optionsError
  );
}