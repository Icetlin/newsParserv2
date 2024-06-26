import {BackendApiClient} from "@/apiclients/BackendApiClient";
import {ParsedNews, ParsedNewsResponse} from "@/interfaces/ParsedNews";
import {useNewsStore} from "@/store/news";

export class ParsedNewsService {
    private client: BackendApiClient;


    constructor() {
        this.client = new BackendApiClient(process.env.VUE_APP_API_PARSED_NEWS_ROUTE);
    }

    async fetchParsedNews(params: Record<string, any>): Promise<ParsedNewsResponse> {
        {
            try {
                return await this.client.get(params);
            } catch (error) {
                console.error("Error fetching parsed news:", error);
                throw error;
            }
        }
    }

    async updateNewsRating(newsList: Map<number, ParsedNews>): Promise<void> {

        let newsListArray = Array.from(newsList)
        for (let i = 0; i < newsListArray.length; i++) {
            let randomInt = Math.floor(Math.random() * 10) + 1;
            let news = newsListArray[i][1];
            let id = news.attributes._id;

            try {
                await this.client.patch(
                    id,
                    {
                        "data": {
                            "type": "parsed-news",
                            "id": id,
                            "attributes": {
                                "rating": randomInt
                            }
                        }
                    }
                    );
            } catch (error) {
                console.error(`Error updating rating for news with id ${id}:`, error);
                throw error;
            }
        }
    }

    async deleteNews(id: number) {
        {
            try {
                return await this.client.delete(id);
            } catch (error) {
                console.error("Error deleting parsed news:", error);
                throw error;
            }
        }
    }
}