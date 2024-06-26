export interface ApiClientInterface
{
    get<T>(url: string): Promise<T>;
    post<T>(id: number, url: string, data: any): Promise<T>;
    put<T>(id: number, url: string, data: any): Promise<T>;
    delete<T>(id: number, url: string, data: any): Promise<T>;
    patch<T>(id: number, url: string, data: any): Promise<T>;
}