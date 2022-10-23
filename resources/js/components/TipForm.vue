<template>
    <div>
        <div class="modal-header">
            <h5 class="modal-title">打賞彈窗</h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="modal"
                aria-label="Close"
            ></button>
        </div>
        <div class="modal-body">
            <form id="form" method="post" action="tip">
                <input type="hidden" name="_token" :value="csrfToken" />
                <div class="form-group">
                    <select
                        name="store_id"
                        required
                        v-model="selected.storeId"
                        @change="loadOptions(selected.storeId)"
                    >
                        <option disabled value="">店家名稱</option>
                        <option
                            v-for="store in options.stores"
                            :value="store.id"
                            :key="store.id"
                        >
                            {{ store.name }}
                        </option>
                    </select>
                    <select
                        name="employee_id"
                        v-model="selected.employeeId"
                        :disabled="!hasSelectStore"
                    >
                        <option disabled value="">員工名稱</option>
                        <option
                            v-for="employee in options.employees"
                            :value="employee.id"
                            :key="employee.id"
                        >
                            {{ employee.name }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>打賞金額</label>
                    <input
                        type="number"
                        name="amount"
                        class="form-control"
                        required
                        v-model="selected.amount"
                    />
                    <div>
                        <span
                            class="badge text-bg-primary"
                            v-for="(amount, i) in options.amounts"
                            :key="i"
                            @click="useDefaultAmount(amount)"
                        >
                            {{ amount }}
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <select name="payment" required v-model="selected.payment">
                        <option disabled value="">支付方式</option>
                        <option
                            v-for="{ value, name } in options.payments"
                            :value="value"
                            :key="value"
                        >
                            {{ name }}
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>評價分數</label>
                    <div v-for="score in 5" :key="score">
                        <input
                            type="radio"
                            name="score"
                            required
                            :id="`rate-${score}`"
                            v-model="selected.score"
                            :value="score"
                        />
                        <label :for="`rate-${score}`">{{ score }}顆星</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>評價</label>
                    <input
                        type="text"
                        class="form-control"
                        name="comment"
                        required
                        v-model="selected.comment"
                    />
                    <div>
                        <span
                            class="badge text-bg-primary"
                            v-for="(comment, i) in options.comments"
                            :key="i"
                            @click="useDefaultComment(comment)"
                        >
                            {{ comment }}
                        </span>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="submit" form="form" class="btn btn-primary">
                送出
            </button>
        </div>
    </div>
</template>
<script>
const createInitSelected = () => ({
    storeId: "",
    employeeId: "",
    payment: "",
    amount: 0,
    score: 0,
    comment: "",
});

export default {
    props: ["storeId", "employeeId"],
    data() {
        return {
            options: {
                stores: [],
                employees: [],
                amounts: [],
                comments: [],
                payments: [
                    { value: 1, name: "信用卡" },
                    { value: 2, name: "PayPay" },
                    { value: 3, name: "Line Pay" },
                ],
            },
            selected: createInitSelected(),
            csrfToken: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        };
    },
    methods: {
        async loadStores() {
            const res = await http.get("stores");
            this.options.stores = res.data.stores;
        },
        async loadOptions(storeId) {
            this.clear(storeId);
            const res = await http.get(`store/${storeId}/options`);
            this.options.employees = res.data.employees;
            this.options.amounts = res.data.amounts;
            this.options.comments = res.data.comments;
        },
        async loadStoreAndOptions(storeId) {
            const [storeRes, optionRes] = await Promise.all([
                http.get("stores"),
                http.get(`store/${storeId}/options`),
            ]);
            this.options.stores = storeRes.data.stores;
            this.options.employees = optionRes.data.employees;
            this.options.amounts = optionRes.data.amounts;
            this.options.comments = optionRes.data.comments;
        },
        clear(storeId) {
            this.selected = createInitSelected();
            this.selected.storeId = storeId; // 保留現在選擇的store id
        },
        useDefaultComment(text) {
            this.selected.comment = text;
        },
        useDefaultAmount(amount) {
            this.selected.amount = amount;
        },
    },
    created() {
        this.selected.storeId = this.storeId ?? this.selected.storeId;
        this.selected.employeeId = this.employeeId ?? this.selected.employeeId;
        if (this.hasSelectStore) this.loadStoreAndOptions(this.storeId);
        else this.loadStores();
    },
    computed: {
        hasSelectStore() {
            return this.selected.storeId != "";
        },
    },
};
</script>
