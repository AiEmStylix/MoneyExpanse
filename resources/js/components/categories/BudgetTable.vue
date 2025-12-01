<script setup lang="ts">
import { columns } from './columns';
import DataTable from './DataTable.vue';

const data = [
    {
        "id": "1",
        "categoryGroup": "Monthly Bills",
        "category": "Rent",
        "assigned": 1500,
        "activity": 0,
        "available": 1500
    },
    {
        "id": "2",
        "categoryGroup": "Monthly Bills",
        "category": "Utilities",
        "assigned": 200,
        "activity": -50,
        "available": 150
    },
    {
        "id": "3",
        "categoryGroup": "Monthly Bills",
        "category": "Internet",
        "assigned": 60,
        "activity": 0,
        "available": 60
    },

    {
        "id": "4",
        "categoryGroup": "Living Expenses",
        "category": "Groceries",
        "assigned": 500,
        "activity": -120,
        "available": 380
    },
    {
        "id": "5",
        "categoryGroup": "Living Expenses",
        "category": "Transport",
        "assigned": 150,
        "activity": -40,
        "available": 110
    },
    {
        "id": "6",
        "categoryGroup": "Living Expenses",
        "category": "Household Supplies",
        "assigned": 80,
        "activity": -20,
        "available": 60
    },

    {
        "id": "7",
        "categoryGroup": "Subscriptions",
        "category": "Netflix",
        "assigned": 15,
        "activity": -15,
        "available": 0
    },
    {
        "id": "8",
        "categoryGroup": "Subscriptions",
        "category": "Spotify",
        "assigned": 10,
        "activity": -10,
        "available": 0
    },
    {
        "id": "9",
        "categoryGroup": "Subscriptions",
        "category": "iCloud Storage",
        "assigned": 3,
        "activity": -3,
        "available": 0
    },

    {
        "id": "10",
        "categoryGroup": "Savings",
        "category": "Emergency Fund",
        "assigned": 300,
        "activity": 0,
        "available": 300
    },
    {
        "id": "11",
        "categoryGroup": "Savings",
        "category": "Travel Fund",
        "assigned": 200,
        "activity": 0,
        "available": 200
    },
    {
        "id": "12",
        "categoryGroup": "Savings",
        "category": "Car Maintenance",
        "assigned": 100,
        "activity": 0,
        "available": 100
    }
]
</script>

<template>
    <DataTable :columns="columns" :data="data" />
</template>