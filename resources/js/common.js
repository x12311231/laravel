import axios from "axios";
function logout() {
    axios.post(config.route.logout, {}).then(function (response) {
        window.location.reload();
    }).catch(function (error) {
        console.log(error)
    })
}
window.logout = logout
