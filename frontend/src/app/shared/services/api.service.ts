import {HttpClient, HttpRequest} from "@angular/common/http";
import {Injectable} from '@angular/core';
import {Observable} from "rxjs";

import {environment} from "../../../environments/environment";


@Injectable({
  providedIn: 'root'
})
export class ApiService {

  constructor(private http: HttpClient) {
  }

  private static url(url: string) {
    return environment.apiURL + '/' + url;
  }

  get(url: string, options: object = {}): Observable<any> {
    return this.http.get(ApiService.url(url), options);
  }

  post(url: string, data: object, options: object = {}): Observable<any> {
    return this.http.post(ApiService.url(url), data, options);
  }

  put(url: string, data: object, options: object = {}): Observable<any> {
    return this.http.put(ApiService.url(url), data, options);
  }

  delete(url: string): Observable<any> {
    return this.http.delete(ApiService.url(url));
  }

  request(method: string, url: string, data: object, options: object): Observable<any> {
    const req = new HttpRequest(method, ApiService.url(url), data, options);
    return this.http.request(req);
  }
}
