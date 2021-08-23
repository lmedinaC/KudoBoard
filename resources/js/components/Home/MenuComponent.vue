<template>
    <v-card class="mx-auto" >
        <v-list>
            <v-list-group
                :prepend-icon="menuItem.action"
                :value="menuItem.active"
                color="light-blue darken-4"
            >
                <template v-slot:activator>
                    <v-list-item-title>{{ menuItem.title }}</v-list-item-title>
                </template>

                <v-list-item
                    @click="
                        changeAdminComponent('HomeAdminComponent'),
                            (menuItem.items.selectedItem = -1),
                            (menuItem.selectSubTitleItem = true)
                    "
                    link
                    v-model="menuItem.selectSubTitleItem"
                >
                    <v-list-item-title
                        v-text="menuItem.subtitle"
                    ></v-list-item-title>

                    <v-list-item-icon>
                        <v-icon v-text="menuItem.subItemAction"></v-icon>
                    </v-list-item-icon>
                </v-list-item>

                <v-list-group
                    v-for="(element, index) of menuItem.items"
                    :key="index"
                    :value="element.active"
                    no-action
                    sub-group
                >
                    <template v-slot:activator>
                        <v-list-item-content>
                            <v-list-item-title>{{
                                element.title
                            }}</v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-icon>
                            <v-icon>{{ element.action }}</v-icon>
                        </v-list-item-icon>
                    </template>

                    <v-list-item-group
                        v-model="menuItem.items.selectedItem"
                        color="primary"
                    >
                        <v-list-item
                            v-for="(e, i) in element.items"
                            :key="i"
                            @click="
                                changeAdminComponent(e.component),
                                    (menuItem.selectSubTitleItem = false)
                            "
                        >
                            <v-list-item-title
                                v-text="e.title"
                            ></v-list-item-title>

                            <v-list-item-icon>
                                <v-icon v-text="e.action"></v-icon>
                            </v-list-item-icon>
                        </v-list-item>
                    </v-list-item-group>
                </v-list-group>
            </v-list-group>
        </v-list>
    </v-card>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
    name: "MenuComponent",
    data() {
        return {
            menuItem: {
                title: "Admin",
                subtitle: "Home",
                active: true,
                selectSubTitleItem: true,
                action: "mdi-menu",
                subItemAction: "mdi-home",
                items: [
                    {
                        title: "Customers",
                        action: "mdi-account-group",
                        active: true,
                        selectedItem: -1,
                        items: [
                            {
                                title: "Create",
                                action: "mdi-account-plus",
                                component: "CreateCustomerComponent",
                                active: false
                            },
                            {
                                title: "Reports",
                                action: "mdi-account-details",
                                component: "ReportCustomerComponent",
                                active: false
                            }
                        ]
                    }
                ]
            }
        };
    },
    methods: {
        ...mapActions(["changeAdminComponent"])
    }
};
</script>
