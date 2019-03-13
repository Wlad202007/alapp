<template>
    <section class="content-wrapper" style="min-height: 960px;">
        <section class="content-header">
            <h1>Agendas</h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <form @submit.prevent="submitForm" novalidate>
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Edit</h3>
                            </div>

                            <div class="box-body">
                                <back-buttton></back-buttton>
                            </div>

                            <bootstrap-alert />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="event">Event *</label>
									<input
                                            type="text"
                                            class="form-control"
                                            name="event"

                                            :value="item.event?item.event.name:''"
                                           readonly
                                    >                                   

                                </div>
								 <div class="form-group">
                                    <label for="date">Date</label>
                                    <date-picker
                                            :value="item.date"
                                            :config="$root.dpconfigDate"
                                            name="date"
                                            placeholder="Enter Date"
                                            @dp-change="updateDate"
                                    >
                                    </date-picker>
                                </div>
								
                                <div class="form-group">
                                    <label for="time">Time *</label>
                                    <date-picker
                                            :value="item.time"
                                            :config="$root.dpconfigTime"
                                            name="time"
                                            placeholder="Enter Time *"
                                            @dp-change="updateTime"
                                    >
                                    </date-picker>
                                </div>
                                <div class="form-group">
                                    <label for="text">Label *</label>
                                    <input
                                            type="text"
                                            class="form-control"
                                            name="label"
                                            placeholder="Enter Text *"
                                            :value="item.label"
                                            @input="updateLabel"
                                    >
                                </div>
                               
                                <div class="form-group">
                                    <label for="text">Text</label>
                                    <vue-ckeditor
                                            name="text"
                                            :id="'text'"
                                            :value="item.text"
                                            @input="updateText"
                                    />
                                </div>
                            </div>

                            <div class="box-footer">
                                <vue-button-spinner
                                        class="btn btn-primary btn-sm"
                                        :isLoading="loading"
                                        :disabled="loading"
                                >
                                    Save
                                </vue-button-spinner>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </section>
</template>


<script>
    import { mapGetters, mapActions } from 'vuex'

    export default {
        data() {
            return {
                // Code...
            }
        },
        computed: {
            ...mapGetters('AgendasSingleevent', ['item', 'loading', 'eventsAll']),
    },
    created() {
        this.fetchData(this.$route.params.id,this.$route.params.event)
    },
    destroyed() {
        this.resetState()
    },
    watch: {
        "$route.params.id": function() {
            this.resetState()
            this.fetchData(this.$route.params.id,this.$route.params.event)
        },
		 "$route.params.event": function() {
            this.resetState()
            this.fetchData(this.$route.params.id,this.$route.params.event)
        }
    },
    methods: {
    ...mapActions('AgendasSingleevent', ['fetchData', 'updateData', 'resetState', 'setEvent', 'setTime', 'setLabel', 'setText', 'setDate']),
        updateEvent(value) {
            this.setEvent(value)
        },
        updateTime(e) {
            this.setTime(e.target.value)
        },
//        updateText(e) {
//            this.setLabel(e.target.value)
//        },
        updateText(value) {
            this.setText(value)
        },
        updateLabel(e) {
            this.setLabel(e.target.value)
        },
        updateDate(e) {
            this.setDate(e.target.value)
        },
        submitForm() {
            let event=this.$route.params.event
			this.updateData()
			     .then(() => {
              //  this.$router.push({ name: 'agendas.event', params: { event: event } })
             this.$router.go(-1)
			this.$eventHub.$emit('update-success')
        })
        .catch((error) => {
                console.error(error)
        })
        }
    }
    }
</script>


<style scoped>

</style>


