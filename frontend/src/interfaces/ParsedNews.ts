
export interface ParsedNewsAttributes {
    _id: number;
    date: string;
    newsUrl: string;
    content: string;
    rating: number;
    source: string;
    title: string;
}

export interface ParsedNews {
    id: string;
    type: string;
    attributes: ParsedNewsAttributes;
}

export interface ApiResponseMeta {
    totalItems: number;
    itemsPerPage: number;
    currentPage: number;
}

export interface ApiResponseLinks {
    self: string;
    first: string;
    last: string;
    next?: string;
    prev?: string;
}

export interface ParsedNewsResponse {
    data: ParsedNews[];
    links: ApiResponseLinks;
    meta: ApiResponseMeta;
}
