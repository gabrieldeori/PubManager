import axios from 'axios';

export default {
  auth(to, _from, next) {
    const localToken = localStorage.getItem('pubmanager_tk_009911');
    if (localToken) {
      const parsedLocalToken = JSON.parse(localToken);
      const { access_token: token, token_type: tokenType } = parsedLocalToken;
      axios.defaults.headers.common.Authorization = `${tokenType} ${token}`;
      if (!token) {
        next({ name: 'Login' });
      } else {
        next();
      }
    }
  },
  loginAuth(to, _from, next) {
    const localToken = localStorage.getItem('pubmanager_tk_009911');
    if (localToken) {
      const parsedLocalToken = JSON.parse(localToken);
      const { access_token: token, token_type: tokenType } = parsedLocalToken;
      axios.defaults.headers.common.Authorization = `${tokenType} ${token}`;
      axios.post(`${process.env.VUE_API_URL}/authorize`).then((response) => {
        if (response.status === 200) {
          next({ name: 'UsersShow' });
        } else {
          next();
        }
      }).catch((error) => {
        console.log(error);
        next();
      });
    } else {
      next();
    }
  },
};
