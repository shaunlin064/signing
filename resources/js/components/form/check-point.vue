<template>
  <div class='col-sm-12'>
    <div class='card'>
      <div class='card-content'>
        <div class='card-body'>
          <h4 class='card-title'>Signing List</h4>
          <!--                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of-->
          <!--                        the card's content.</p>-->
        </div>
        <ul class='list-group list-group-flush'>
          <li class='list-group-item'>
            <div class='row'>
              <div class='col-sm-1 d-flex justify-content-center'>簽核人</div>
              <div class='col-sm-2 d-flex justify-content-center'>身份</div>
              <div class='col-sm-2 d-flex justify-content-center'>代簽人</div>
              <div class='col-sm-1 d-flex justify-content-center'>簽核狀態</div>
              <div class='col-sm-2 d-flex justify-content-center'>簽核日期</div>
              <div class='col-sm-3 d-flex justify-content-center'>備註</div>
            </div>
          </li>
          <li class='list-group-item' v-for='item in check_list' @model='check_list'>
            <div class='row'>
              <div class='col-sm-1 d-flex justify-content-center'>{{ getMember(item.signed_member_id) }}
              </div>
              <div class='col-sm-2 d-flex justify-content-center'>{{ item.check_point_name }}
                {{ item.role_str }}
              </div>
              <div class='col-sm-2 d-flex justify-content-center'>
                {{ getReplace(item.replace_signed_member_id) }}
              </div>
              <div class='col-sm-1 d-flex justify-content-center' v-html='statusBadge(item.status)'>}
              </div>
              <div class='col-sm-2 d-flex justify-content-center' v-html='item.signed_at'></div>
              <div class='col-12 col-sm-3 d-flex justify-content-center'>{{ item.remark }}</div>
            </div>

            <!--                        <span class="badge badge-pill bg-primary float-right">4</span>-->

          </li>
        </ul>
        <div class='card-body d-flex justify-content-end' v-if='can_check'>
          <div class='row'>
            <button type='button' class='btn btn-primary mr-1 mb-1 waves-effect waves-light text-right'
                    @click='confer("Confer")'>
                            <span role='status' aria-hidden='true' class='spinner-grow spinner-grow-sm'
                                  v-show='lodding'></span>
              <strong>通過</strong>
            </button>
            <button type='button' class='btn btn-danger mr-1 mb-1 waves-effect waves-light text-right'
                    @click='confer("Reject")'>
                            <span role='status' aria-hidden='true' class='spinner-grow spinner-grow-sm'
                                  v-show='lodding'></span>
              <strong>駁回</strong>
            </button>
          </div>

        </div>
      </div>
    </div>
    <div class='content' v-show='show'>
      <div class='modal-backdrop fade show'></div>
      <div class='confirm_signature'>
        <div class='modal fade text-left' :class='show ? "show" : ""' :style='show ? styleList : {}'
             id='backdrop'>
          <div class='modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md' role='document'>
            <div class='modal-content'>
              <div class='modal-header'>
                <h4 class='modal-title' id='myModalLabel4'>目前預設簽名檔</h4>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                  <span aria-hidden='true' @click='close'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                <div class='card'>
                  <img class='card-img-top img-fluid mb1' :src='image_base64'>
                </div>
              </div>
              <div class='modal-footer d-flex justify-content-between'>
                <a href='/signature'
                   class='btn btn-outline-warning mr-1 mb-1 waves-effect waves-light'>更換簽名檔</a>
                <button class='btn btn-primary mr-1 mb-1 waves-effect waves-light' type='button' @click='submit'
                        :disabled='lodding'>
                  <span class='spinner-border spinner-border-sm' role='status' aria-hidden='true' v-if='lodding'></span>
                  確認
                </button>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import {mapState} from 'vuex';
import {apiFormChecking} from '../../src/apis/form';
import signature from "../../mixins/signature";

export default {
  name: "check-point",
  props: {
    check_list_props: Array,
    form_id: Number,
    can_check: Boolean,
    check_id: Number,
  },
  data() {
    return {
      lodding: false,
      check_list: null,
      postData: {
        id: '',
        member_id: '',
        signature: '',
        remark: '',
        status: 0,
      },

    }
  },
  mixins: [signature],
  computed: {
    ...mapState(['login_user', 'member', 'department', 'form_submit_data']),
  },
  beforeMount: function () {
  },
  mounted: function () {
    this.asyncGet();
  },
  methods: {
    async asyncGet() {
      let vue = this;

      while (this.check_list === null) {
        this.check_list = await this.settime();
      }
      this.postData.id = this.check_id;
      this.postData.member_id = this.login_user.id;
    },
    settime() {
      let vue = this;
      return new Promise((resolve, reject) => {
        setTimeout(() => {
          resolve(vue.check_list_props)
        }, 500)
      });
    },
    getReplace(id) {
      if (id) {
        return `${this.getMember(id)}`
      }
    },
    getMember(id) {
      if (id) {
        return getMember(id);
      }
    },
    statusBadge(status) {
      let className = '';
      let html = '';
      switch (status) {
        case 0:
          className = 'danger'
          html = '駁回'
          break;
        case 1:
          className = 'warning'
          html = '待簽核'
          break;
        case 2:
          className = 'success'
          html = '通過'
          break;
        default:
          className = 'secondary'
          html = '錯誤'
          break;
      }
      return `<div class='badge badge-${className}'>${html}</div>`
    },
    submit() {
      let vue = this;
      vue.lodding = true;
      vue.postData.api_token = vue.login_user.api_token;
      apiFormChecking(vue.postData)
          .then(function (response) {
            vue.show = false;
            vue.lodding = false;
            vue.swalSuccess({value: response.data});
          });
    },
    swalCancel() {
      Swal.fire({
        title: 'Cancelled',
        text: 'This From Apply file is safe :)',
        type: 'error',
        confirmButtonClass: 'btn btn-success',
      })
    },
    swalSuccess(result) {
      let type = result.value.status == 1 ? 'success' : 'error';
      let timerInterval;

      let swalConfig = {
        type,
        title: `${result.value.status_string}`,
        html: ` ${result.value.message} <b></b>`,
      }

      if (result.value.status == 1) {
        swalConfig.timer = 2000;
        swalConfig.onBeforeOpen = () => {
          Swal.showLoading()
          timerInterval = setInterval(() => {
            const content = Swal.getContent()
            if (content) {
              const b = content.querySelector('b')
              if (b) {
                b.textContent = Math.round(Swal.getTimerLeft() / 1000, 1);
              }
            }
          }, 100)
        };
        swalConfig.onClose = () => {
          clearInterval(timerInterval)
        };
      } else {
        swalConfig.confirmButtonClass = 'btn btn-success';
      }
      Swal.fire(swalConfig
      ).then(result => {
        if (type === 'success') {
          javascript:location.href = '/form-edit?id=' + this.form_id;
        }
      })
    },
    noSignature() {
      let type = 'error';
      let timerInterval;

      let swalConfig = {
        type,
        title: `沒有設定簽名檔`,
        html: `頁面將轉移至簽名檔設定 <b></b>`,
      }
      swalConfig.timer = 2000;
      swalConfig.onBeforeOpen = () => {
        Swal.showLoading()
        timerInterval = setInterval(() => {
          const content = Swal.getContent()
          if (content) {
            const b = content.querySelector('b')
            if (b) {
              b.textContent = Math.round(Swal.getTimerLeft() / 1000, 1);
            }
          }
        }, 100)
      };
      swalConfig.onClose = () => {
        clearInterval(timerInterval)
      };

      Swal.fire(swalConfig
      ).then(result => {
        javascript:location.href = '/signature';
      })
    },
    async confer(action) {
      let vue = this;
      this.postData.status = action == 'Confer' ? 2 : 0;
      let swalConfig = {
        title: 'Are you sure?',
        text: "通過簽核後將無法退回",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: `Yes, ${action} it!`,
        confirmButtonClass: 'btn btn-primary',
        cancelButtonClass: 'btn btn-danger ml-1',
        buttonsStyling: false,
      }
      if (action == 'Confer') {
        swalConfig.showLoaderOnConfirm = true;

        /*取簽名檔*/
        swalConfig.preConfirm = (result) => {
          return this.signature_items;
        };
        Swal.fire(
            swalConfig
        ).then((result) => {

          if (result.value !== undefined) {
            let data = result.value;
            $('body').css('overflow', 'hidden');

            if (data[0]) {
              data.map((v) => {
                /* 如果都沒有favorite 設定第一個當作default*/
                this.image_base64 = data[0].image_base64;
                this.postData.signatures_id = data[0].id;
                this.show = true;
                if (v.favorite === 1) {
                  this.image_base64 = v.image_base64;
                  this.postData.signatures_id = v.id;
                  this.show = true;
                }
              })
              this.signature_items = data;
            } else {
              vue.noSignature();
            }
          } else {
            vue.swalCancel();
          }


        })
      } else {
        Swal.fire(
            swalConfig
        ).then((result) => {
          if (result.value !== undefined) {
            Swal.fire({
              title: `${action}`,
              text: "請輸入原因",
              type: 'question',
              input: 'text',
              confirmButtonColor: '#3085d6',
              confirmButtonText: `送出`,
              confirmButtonClass: 'btn btn-primary',
              buttonsStyling: false,
              inputValidator: (value) => {
                if (!value) {
                  return 'You need to write something!'
                }
              },
              showLoaderOnConfirm: true,
              preConfirm: (remark) => {
                vue.postData.remark = remark;
                vue.postData.api_token = vue.login_user.api_token;
                return apiFormChecking(vue.postData)
                    .then(function (response) {
                      return response.data;
                    })
                    .catch(function (error) {
                      Swal.showValidationMessage(
                          `Request failed: ${error}`
                      )
                    });
              }
            }).then((result) => {
              if (result.value !== undefined) {
                vue.swalSuccess(result);
              } else {
                vue.swalCancel();
              }
            });
          } else {
            vue.swalCancel();
          }
        });
      }
    }
  }
  ,
  updated() {
  }
  ,
  watch: {}
}
</script>

<style scoped>
#backdrop {
  display: list-item !important;
  overflow: auto;
}

.card {
  margin: 0;
}
</style>
