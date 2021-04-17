<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Echo from "laravel-echo";
    import Pusher from "pusher-js";
    export default {
        mounted() {
            console.log('Component mounted.');
            this.startBroadcast();
        },

        methods : {
            startBroadcast(){
                axios
                .post("https://one.main/api/login", {
                    email: "admin@onelab.com",
                    password: "123456",
                })
                .then(({ data }) => {
                    console.log(data.access_token);
                    let token = data.access_token;
                    //
                    axios({
                    method: "GET",
                    url: "https://one.main/api/check",
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                    }).then(({ data }) => {
                    console.log(data);

                    let echo = new Echo({
                        broadcaster: "pusher",
                        key: "d29b401cc20a3d58e290",
                        cluster: "ap1",
                        encrypted: true,
                        authorizer: (channel, options) => {
                        console.log(options);
                        return {
                            authorize: (socketId, callback) => {
                            axios({
                                method: "POST",
                                url: "https://one.main/api/broadcasting/auth",
                                headers: {
                                Authorization: `Bearer ${token}`,
                                },
                                data: {
                                socket_id: socketId,
                                channel_name: channel.name,
                                },
                            })
                                .then((response) => {
                                callback(false, response.data);
                                })
                                .catch((error) => {
                                callback(true, error);
                                });
                            },
                        };
                        },
                    });

                    echo.join(`chat-${data.id}`).listen("NewConversationMessage", (data) => {
                        console.log(data);
                    });
                    });
                });
            }
        }
    }
</script>
