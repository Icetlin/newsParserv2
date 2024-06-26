import axios, { AxiosInstance } from 'axios';
import { ApiClientInterface } from "@/interfaces/ApiClientInterface";

export class BackendApiClient implements ApiClientInterface {
    private client: AxiosInstance;
    private readonly dynamicPart: string;

    constructor(dynamicPart: string, headers: Record<string, string> | null = null) {
        this.client = axios.create({
            baseURL: process.env.VUE_APP_BASE_BACKEND_URI + dynamicPart,
            headers: headers || { 'Content-Type': 'application/vnd.api+json' },
        });
        this.dynamicPart = process.env.VUE_APP_BASE_BACKEND_URI + dynamicPart
    }

    async get<T>(params: any): Promise<T> {
        const response = await this.client.get('', { params });
        return response.data;
    }

    async post<T>(data: any): Promise<T> {
        const response = await this.client.post('', data);
        return response.data;
    }

    async put<T>(data: any): Promise<T> {
        const response = await this.client.put('', data);
        return response.data;
    }

    async delete<T>(id:number): Promise<T> {
        const response = await this.client.delete(this.dynamicPart + "/" + id);
        return response.data;
    }

    async patch<T>(id:number, data: any): Promise<T> {
        const response = await this.client.patch(this.dynamicPart + "/" + id, data);
        return response.data;
    }
}
