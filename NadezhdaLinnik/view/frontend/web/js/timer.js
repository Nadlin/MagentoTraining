define([
    'uiComponent',
    'jquery'
], function (Component, $) {
    return Component.extend({
        defaults: {
            hours: '00',
            minutes: '00',
            seconds: '00',
            startTime: false,
            timerStart: false,
            timer: null,
            timeDifference: false
        },

        initObservable: function () {
            this._super()
                .observe(['hours', 'minutes', 'seconds']);

            return this;
        },

        startCountdown: function () {
            if (!this.startTime) {
                this.startTime = new Date();
                this.startTime = this.startTime.getTime();
            } else {
                var continueTime = new Date();
                continueTime = continueTime.getTime();
                this.startTime = continueTime - this.timeDifference;
            }

            this.timer = setInterval(function () {
                var currentTime, timeDif, hours, minutes, seconds;
                currentTime = new Date();
                currentTime = currentTime.getTime();
                this.timeDifference = currentTime - this.startTime;
                timeDif = this.timeDifference/1000;
                hours = Math.floor(timeDif / 3600);
                if (hours < 10) {
                    hours = '0' + hours;
                }

                minutes = Math.floor((timeDif - hours * 3600) / 60);

                if (minutes < 10) {
                    minutes = '0' + minutes;
                } else if (minutes == 60) {
                    minutes = '00';
                }

                seconds = Math.floor(timeDif - hours * 3600 - minutes * 60);

                if (seconds < 10) {
                    seconds = '0' + seconds;
                } else if (seconds == 60) {
                    seconds = '00';
                }
                this.hours(hours);
                this.minutes(minutes);
                this.seconds(seconds);
            }.bind(this), 1000);
        },

        stopCountdown: function () {
            if (this.startTime) {
                clearInterval(this.timer);
                this.hours('00');
                this.minutes('00');
                this.seconds('00');
                this.startTime = false;
                this.timeDifference = false;
            }
        },

        pauseCountdown: function () {
            if (this.startTime) {
                clearInterval(this.timer);
            }
        }
    })
})
