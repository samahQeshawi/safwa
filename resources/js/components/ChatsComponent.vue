<template>


<div class="row">
        <div class="col-md-6">
            <!-- DIRECT CHAT PRIMARY -->
            <div class="card card-primary card-outline direct-chat direct-chat-primary">
                <div class="card-header">
                    <h3 class="card-title">{{ chatTitle }}</h3>

                    <div class="card-tools">
                        <span title="" class="badge bg-primary">{{users.length}} Users</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" title="Contacts" data-widget="chat-pane-toggle">
                            <i class="fas fa-comments"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages" v-chat-scroll >
                        <!-- Message. Default to the left -->
                        <div class="direct-chat-msg" :class="{'right':(message.user.id !== user.id)}" v-for="(message, index) in messages" :key="index">
                            <div class="direct-chat-infos clearfix">
                                <span class="direct-chat-name" :class="{'float-left':(message.user.id === user.id), 'float-right':(message.user.id !== user.id)}" >{{ message.user.name}}</span>
                                <span class="direct-chat-timestamp " :class="{'float-right':(message.user.id === user.id), 'float-left':(message.user.id !== user.id)}">23 Jan 2:00 pm</span>
                            </div>
                            <!-- /.direct-chat-infos -->
                            <img class="direct-chat-img" src="https://picsum.photos/129" alt="Message User Image">
                            <!-- /.direct-chat-img -->
                            <div class="direct-chat-text">
                                {{ message.message }}
                            </div>
                            <!-- /.direct-chat-text -->
                        </div>
                        <span class="text-muted" v-if="activeUser" >{{ activeUser.name }} is typing...</span>
                        <!-- /.direct-chat-msg -->

                    </div>
                    <!--/.direct-chat-messages-->

                    <!-- Contacts are loaded here -->
                    <div class="direct-chat-contacts">
                        <ul class="contacts-list">
                            <li v-for="(user, index) in users" :key="index">
                                <a href="#">
                                    <img class="contacts-list-img" src="https://picsum.photos/128"
                                        alt="User Avatar">

                                    <div class="contacts-list-info">
                                        <span class="contacts-list-name">
                                            {{ user.name }}
                                            <small class="contacts-list-date float-right">2/28/2015</small>
                                        </span>
                                        <span class="contacts-list-msg">How have you been? I was...</span>
                                    </div>
                                    <!-- /.contacts-list-info -->
                                </a>
                            </li>
                            <!-- End Contact Item -->
                        </ul>
                        <!-- /.contatcts-list -->
                    </div>
                    <!-- /.direct-chat-pane -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">

                        <div class="input-group">
                            <input
                                @keydown="sendTypingEvent"
                                @keyup.enter="sendMessage"
                                v-model="newMessage"
                                type="text"
                                name="message"
                                placeholder="Enter your message..."
                                class="form-control">
                            <!-- <span class="input-group-append">
                                <button type="submit" class="btn btn-primary">Send</button>
                            </span> -->
                        </div>

                </div>
                <!-- /.card-footer-->
            </div>
            <!--/.direct-chat -->
        </div>


    <div class="col-md-3">
        <!-- USERS LIST -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Users</h3>

                <div class="card-tools">
                    <span class="badge badge-danger">{{ users.length }} Users</span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="users-list clearfix">
                    <li v-for="(user, index) in users" :key="index" v-on:click="selectUser(user)">
                        <!-- <img v-if=user.profile_image  src={{ user.profile_image }} alt="User Image">
                        <img v-else  src={{ asset('storage/images/no-image.jpg') }} alt="User Image"> -->
                        <img src="https://picsum.photos/50" alt="User Image">
                        <a class="users-list-name" href="javascript:">{{ user.name }}</a>
                        <span class="users-list-date">{{ user.phone }}</span>
                    </li>
                    <li v-on:click="selectUser(0)">
                        <img src="https://picsum.photos/50" alt="User Image">
                        <a class="users-list-name" href="javascript:">All Users</a>

                    </li>
                </ul>
                <!-- /.users-list -->
            </div>
            <!-- /.card-body -->
            <!-- <div class="card-footer text-center">
                <a href="javascript:">View All Users</a>
            </div> -->
            <!-- /.card-footer -->
        </div>
        <!--/.card -->
    </div>



     <div class="col-md-3">
        <!-- USERS LIST -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Groups</h3>

                <div class="card-tools">
                    <span class="badge badge-danger">{{ groups.length }} Groups</span>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="users-list clearfix">
                    <li v-for="(group, index) in groups" :key="index" v-on:click="selectGroup(group)">
                        <img src="https://picsum.photos/50" alt="User Image">
                        <a class="users-list-name" href="javascript:">{{ group.title }}</a>

                    </li>
                    <li v-on:click="selectGroup(0)">
                        <img src="https://picsum.photos/50" alt="User Image">
                        <a class="users-list-name" href="javascript:">All Users</a>

                    </li>
                </ul>
                <!-- /.users-list -->
            </div>
            <!-- /.card-body -->
            <!-- <div class="card-footer text-center">
                <a href="javascript:">View All Users</a>
            </div> -->
            <!-- /.card-footer -->
        </div>
        <!--/.card -->
    </div>


</div>






<!--

   <div class="row">

       <div class="col-8">
           <div class="card card-default">
               <div class="card-header">Messages</div>
               <div class="card-body p-0">
                   <ul class="list-unstyled" style="height:300px; overflow-y:scroll" v-chat-scroll>
                       <li class="p-2" v-for="(message, index) in messages" :key="index" >
                           <strong>{{ message.user.name }}</strong>
                           {{ message.message }}
                       </li>
                   </ul>
               </div>

               <input
                    @keydown="sendTypingEvent"
                    @keyup.enter="sendMessage"
                    v-model="newMessage"
                    type="text"
                    name="message"
                    placeholder="Enter your message..."
                    class="form-control">
           </div>
            <span class="text-muted" v-if="activeUser" >{{ activeUser.name }} is typing...</span>
       </div>

        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">Active Users</div>
                <div class="card-body">
                    <ul>
                        <li class="py-2" v-for="(user, index) in users" :key="index">
                            {{ user.name }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

   </div> -->
</template>

<script>
    export default {

        props:['user'],

        data() {
            return {
                messages: [],
                newMessage: '',
                currentGroup:0,
                currentUser:0,
                users:[],
                groups:[],
                groupUsers:[],
                activeUser: false,
                typingTimer: false,
                chatTitle: 'All Uers'
            }
        },

        created() {
            this.fetchMessages();
            this.fetchGroups();
            //this.fetchGroupUsers();

            Echo.join('chat')
                .here(user => {
                    this.users = user;
                })
                .joining(user => {
                    this.users.push(user);
                })
                .leaving(user => {
                    this.users = this.users.filter(u => u.id != user.id);
                })
                .listen('MessageSent',(event) => {
                    this.messages.push(event.message);
                })
                .listenForWhisper('typing', user => {
                   this.activeUser = user;

                    if(this.typingTimer) {
                        clearTimeout(this.typingTimer);
                    }

                   this.typingTimer = setTimeout(() => {
                       this.activeUser = false;
                   }, 3000);
                })

        },

        methods: {
            selectGroup($e) {
                this.currentGroup = $e ? $e.id : 0;
                this.chatTitle = $e ? $e.title : 'All Users';
                this.fetchGroupMessages();
                //this.fetchGroupUsers();
            },

            selectUser($e) {
                this.currentUser = $e ? $e.id : 0;
                this.chatTitle = $e ? $e.name : 'All Users';
                this.fetchUserMessages();
                //this.fetchGroupUsers();
            },

            fetchMessages() {
                axios.get('messages').then(response => {
                    this.messages = response.data;
                })
            },

            fetchGroups() {
                axios.get('fetch_groups').then(response => {
                    this.groups = response.data;
                })
            },

            fetchGroupUsers() {
                if (this.currentGroup != 0)
                    axios.get('fetch_group_users/'+this.currentGroup).then(response => {
                        this.users = response.data;
                    })
            },

            fetchGroupMessages() {
                axios.get('group_messages/'+this.currentGroup).then(response => {
                    this.messages = response.data;
                })
            },

            fetchUserMessages() {
                axios.get('user_messages/'+this.currentUser).then(response => {
                    this.messages = response.data;
                })
            },

            sendMessage() {

                this.messages.push({
                    user: this.user,
                    message: this.newMessage
                });

                axios.post('messages', {message: this.newMessage, group: this.currentGroup, user: this.currentUser});

                this.newMessage = '';
            },

            sendTypingEvent() {
                Echo.join('chat')
                    .whisper('typing', this.user);
            }
        }
    }
</script>
